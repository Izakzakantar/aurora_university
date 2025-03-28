<?php
/*session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}*/

require_once 'Database.php';
require_once 'classes/AttributionMatiereManager.php';

$db = new Database();
$manager = new AttributionMatiereManager($db);
$conn = $db->getConnection();

$enseignants = $conn->query("SELECT u.id, u.nom, u.prenom FROM Utilisateurs u JOIN Enseignants e ON u.id = e.id")->fetch_all(MYSQLI_ASSOC);

$success = "";
$edit_mode = false;
$attribution_a_modifier = null;

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $attribution_a_modifier = $manager->getById(intval($_GET['edit']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enseignant_id = intval($_POST['enseignant_id']);
    $classe_nom = trim($_POST['classe_nom']);
    $matiere_nom = trim($_POST['matiere_nom']);

    $stmt = $conn->prepare("SELECT id FROM Classes WHERE nom = ?");
    $stmt->bind_param("s", $classe_nom);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($classe_id);
        $stmt->fetch();
    } else {
        $insert = $conn->prepare("INSERT INTO Classes (nom, niveau, annee_scolaire) VALUES (?, '', '')");
        $insert->bind_param("s", $classe_nom);
        $insert->execute();
        $classe_id = $insert->insert_id;
    }

    $stmt = $conn->prepare("SELECT id FROM Matieres WHERE nom = ?");
    $stmt->bind_param("s", $matiere_nom);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($matiere_id);
        $stmt->fetch();
    } else {
        $insert = $conn->prepare("INSERT INTO Matieres (nom) VALUES (?)");
        $insert->bind_param("s", $matiere_nom);
        $insert->execute();
        $matiere_id = $insert->insert_id;
    }

    if (isset($_POST['ajouter'])) {
        $manager->ajouter($enseignant_id, $classe_id, $matiere_id);
        $success = "Matière attribuée avec succès.";
    }

    if (isset($_POST['modifier'])) {
        $id = intval($_POST['id']);
        $manager->modifier($id, $enseignant_id, $classe_id, $matiere_id);
        echo "<script>window.location.href = 'attribution_matieres.php?updated=1';</script>";
        exit;
    }
}

if (isset($_GET['supprimer'])) {
    $manager->supprimer(intval($_GET['supprimer']));
    header("Location: attribution_matieres.php?deleted=1");
    exit;
}

if (isset($_GET['updated'])) {
    $success = "Attribution modifiée avec succès.";
}

$attributions = $manager->lister();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attribution des matières</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Teachers&display=swap" rel="stylesheet">
  <style>
    body { min-height: 100vh; display: flex; background-color: #f8f9fa; font-family: 'Teachers', sans-serif; }
    .sidebar { width: 250px; background-color: #343a40; color: white; padding-top: 1rem; }
    .sidebar a { color: white; display: block; padding: 0.75rem 1.25rem; text-decoration: none; }
    .sidebar a:hover { background-color: #495057; }
    .content { flex-grow: 1; padding: 2rem; }
    .btn-custom { background-color: #7C671B; color: white; border: none; }
    .btn-custom:hover { background-color: #6a5818; color: white; }
    #form-section { display: block; }
  </style>
</head>
<body>
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Admin Panel</h4>
  <hr>
  <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="manage_enseignants.php"><i class="bi bi-person-badge me-2"></i>Gestion des enseignants</a>
  <a href="manage_eleves.php"><i class="bi bi-people-fill me-2"></i>Gestion des élèves</a>
  <a href="attribution_classes.php"><i class="bi bi-building me-2"></i>Attribution des classes</a>
  <a href="attribution_matieres.php"><i class="bi bi-book-half me-2"></i>Attribution des matières</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Attribution des matières aux enseignants</h2>
  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <button class="btn btn-custom mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle"></i> Nouvelle attribution
  </button>

  <div id="form-section" class="card p-3 mb-4 shadow-sm animate__animated animate__fadeIn">
    <form method="POST">
      <?php if ($edit_mode): ?>
        <input type="hidden" name="modifier" value="1">
        <input type="hidden" name="id" value="<?= $attribution_a_modifier['id'] ?? '' ?>">
      <?php else: ?>
        <input type="hidden" name="ajouter" value="1">
      <?php endif; ?>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Enseignant</label>
          <select class="form-select" name="enseignant_id" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach ($enseignants as $e): ?>
              <option value="<?= $e['id'] ?>" <?= $edit_mode && isset($attribution_a_modifier['enseignant_id']) && $e['id'] == $attribution_a_modifier['enseignant_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['prenom'] . ' ' . $e['nom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label>Classe</label>
          <input type="text" class="form-control" name="classe_nom" required value="<?= $edit_mode && isset($attribution_a_modifier['classe_nom']) ? htmlspecialchars($attribution_a_modifier['classe_nom']) : '' ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label>Matière</label>
          <input type="text" class="form-control" name="matiere_nom" required value="<?= $edit_mode && isset($attribution_a_modifier['matiere_nom']) ? htmlspecialchars($attribution_a_modifier['matiere_nom']) : '' ?>">
        </div>
      </div>
      <button type="submit" class="btn btn-custom"><?= $edit_mode ? 'Modifier' : 'Attribuer' ?></button>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>#</th>
          <th>Enseignant</th>
          <th>Classe</th>
          <th>Matière</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($attributions as $a): ?>
        <tr class="animate__animated animate__fadeInUp">
          <td><?= $a['id'] ?></td>
          <td><?= htmlspecialchars($a['enseignant_prenom'] . ' ' . $a['enseignant_nom']) ?></td>
          <td><?= htmlspecialchars($a['classe_nom']) ?></td>
          <td><?= htmlspecialchars($a['matiere_nom']) ?></td>
          <td>
            <a href="?edit=<?= $a['id'] ?>" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil-square"></i> Modifier
            </a>
            <a href="?supprimer=<?= $a['id'] ?>" onclick="return confirm('Confirmer la suppression ?')" class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i> Supprimer
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  function toggleForm() {
    const form = document.getElementById('form-section');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
  }
</script>
</body>
</html>
