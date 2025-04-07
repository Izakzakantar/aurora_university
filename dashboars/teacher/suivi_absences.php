<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Enseignant') {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/AbsenceManager.php';

$db = new Database();
$conn = $db->getConnection();
$manager = new AbsenceManager($db);

$enseignant_id = $_SESSION['user_id'];

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eleve_nom = trim($_POST['eleve_nom']);
    $matiere_nom = trim($_POST['matiere_nom']);
    $date = $_POST['date_absence'];
    $statut = $_POST['statut'];
    $remarque = trim($_POST['remarque']);

    // Récupérer l’ID de l’élève
    $stmt = $conn->prepare("SELECT id FROM Utilisateurs WHERE  nom = ?");
    $stmt->bind_param("s", $eleve_nom);
    $stmt->execute();
    $stmt->bind_result($eleve_id);
    $stmt->fetch();
    $stmt->close();

    // Récupérer l’ID de la matière
    $stmt = $conn->prepare("SELECT id FROM Matieres WHERE nom = ?");
    $stmt->bind_param("s", $matiere_nom);
    $stmt->execute();
    $stmt->bind_result($matiere_id);
    $stmt->fetch();
    $stmt->close();

    if ($eleve_id && $matiere_id) {
        if ($manager->ajouter($eleve_id, $matiere_id, $date, $statut, $remarque)) {
            $success = "✅ Absence enregistrée avec succès.";
        }
    } else {
        $success = "❌ Élève ou matière introuvable.";
    }
}

$absences = $manager->listerParEnseignant($enseignant_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suivi des absences</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Teachers&display=swap" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      background-color: #f8f9fa;
      font-family: 'Teachers', sans-serif;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding-top: 1rem;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 0.75rem 1.25rem;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .content {
      flex-grow: 1;
      padding: 2rem;
    }
    .btn-custom {
      background-color: #7C671B;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #6a5818;
    }
    #form-section {
      display: none;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Espace Enseignant</h4>
  <hr>
  <a href="teacher_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="saisie_notes.php"><i class="bi bi-pencil-square me-2"></i>Saisie des notes</a>
  <a href="historique_eleves.php"><i class="bi bi-journal-text me-2"></i>Historique scolaire</a>
  <a href="suivi_absences.php"><i class="bi bi-exclamation-circle me-2"></i>Absences & Retards</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<!-- Contenu -->
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Suivi des absences et retards</h2>

  <?php if ($success): ?>
    <div class="alert alert-info"><?= $success ?></div>
  <?php endif; ?>

  <button class="btn btn-custom mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle"></i> Ajouter une absence/retard
  </button>

  <!-- Formulaire -->
  <div id="form-section" class="card p-3 mb-4 shadow-sm animate__animated animate__fadeIn">
    <form method="POST">
      <div class="row">
        <div class="col-md-3 mb-3">
          <label>Nom complet de l’élève</label>
          <input type="text" class="form-control" name="eleve_nom" required>
        </div>
        <div class="col-md-3 mb-3">
          <label>Nom de la matière</label>
          <input type="text" class="form-control" name="matiere_nom" required>
        </div>
        <div class="col-md-2 mb-3">
          <label>Date</label>
          <input type="date" class="form-control" name="date_absence" required>
        </div>
        <div class="col-md-2 mb-3">
          <label>Statut</label>
          <select class="form-select" name="statut" required>
            <option>Absent</option>
            <option>Retard</option>
            <option>Excusé</option>
            <option>Présent</option>
          </select>
        </div>
        <div class="col-md-12 mb-3">
          <label>Remarque</label>
          <textarea class="form-control" name="remarque" rows="2" placeholder="Remarque facultative..."></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-custom">Enregistrer</button>
    </form>
  </div>

  <!-- Tableau dynamique -->
  <div class="table-responsive">
  
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>Élève</th>
          <th>Date</th>
          <th>Matière</th>
          <th>Statut</th>
          <th>Remarque</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($absences as $a): ?>
        <tr class="animate__animated animate__fadeInUp">
          <td><?= htmlspecialchars($a['nom']) ?></td>
          <td><?= htmlspecialchars($a['date_absence']) ?></td>
          <td><?= htmlspecialchars($a['matiere_nom']) ?></td>
          <td>
            <?php
              $badge = match($a['statut']) {
                'Absent' => 'bg-danger',
                'Retard' => 'bg-warning text-dark',
                'Excusé' => 'bg-info text-dark',
                'Présent' => 'bg-success',
                default => 'bg-secondary'
              };
            ?>
            <span class="badge <?= $badge ?>"><?= $a['statut'] ?></span>
          </td>
          <td><?= htmlspecialchars($a['remarque']) ?></td>
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
