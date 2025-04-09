<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

require_once 'Database.php';
require_once 'classes/EnseignantManager.php';

$db = new Database();
$enseignantManager = new EnseignantManager($db);
$erreur = "";
$success = "";

// Mode édition ?
$enseignant_a_modifier = null;
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    foreach ($enseignantManager->lister() as $e) {
        if ($e['id'] == $edit_id) {
            $enseignant_a_modifier = $e;
            $edit_mode = true;
            break;
        }
    }
}

//  Ajouter un enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $specialite = htmlspecialchars(trim($_POST['specialite']));
    $telephone = !empty($_POST['telephone']) ? htmlspecialchars(trim($_POST['telephone'])) : null;
    $motdepasse = htmlspecialchars(trim($_POST['motdepasse']));

    if (strlen($motdepasse) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($enseignantManager->emailExiste($email)) {
        $erreur = "L'adresse email est déjà utilisée par un autre utilisateur.";
    } else {
        $enseignantManager->ajouter($nom, $prenom, $email, $motdepasse, $specialite, $telephone);
        $success = "Enseignant ajouté avec succès.";
    }
}

//  Modifier un enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $id = intval($_POST['id']);
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $specialite = htmlspecialchars(trim($_POST['specialite']));
    $telephone = !empty($_POST['telephone']) ? htmlspecialchars(trim($_POST['telephone'])) : null;

    $enseignantManager->modifier($id, $nom, $prenom, $email, $specialite, $telephone);
    $success = "Enseignant modifié avec succès.";
    header("Location: manage_enseignants.php?updated=1");
    exit;

}

//  Supprimer un enseignant
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    $enseignantManager->supprimer($id);
    header("Location: manage_enseignants.php?deleted=1");
    exit;
}

//  Liste des enseignants
$enseignants = $enseignantManager->lister();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestion des enseignants</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Teachers&display=swap" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      display: flex;
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
      color: white;
    }
    #form-section {
      display: block;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Admin Panel</h4>
  <hr>
  <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="manage_enseignants.php"><i class="bi bi-person-badge me-2"></i>Gestion des enseignants</a>
  <a href="manage_eleves.php"><i class="bi bi-people-fill me-2"></i>Gestion des élèves</a>
  <a href="attribution_classes.php"><i class="bi bi-building me-2"></i>Attribution des classes et matieres</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<!-- Contenu principal -->
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Gestion des enseignants</h2>

  <?php if ($erreur): ?>
    <div class="alert alert-danger"><?= $erreur ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <button class="btn btn-custom mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle"></i> Ajouter un enseignant
  </button>

  <!-- Formulaire d'ajout/modification -->
  <div id="form-section" class="card p-3 mb-4 shadow-sm animate__animated animate__fadeIn">
    <form method="POST">
      <?php if ($edit_mode): ?>
        <input type="hidden" name="modifier" value="1">
        <input type="hidden" name="id" value="<?= $enseignant_a_modifier['id'] ?>">
      <?php else: ?>
        <input type="hidden" name="ajouter" value="1">
      <?php endif; ?>
      <div class="row">
        <div class="col-md-3 mb-3">
          <label>Nom</label>
          <input type="text" class="form-control" name="nom" required value="<?= $edit_mode ? htmlspecialchars($enseignant_a_modifier['nom']) : '' ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label>Prénom</label>
          <input type="text" class="form-control" name="prenom" required value="<?= $edit_mode ? htmlspecialchars($enseignant_a_modifier['prenom']) : '' ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label>Email</label>
          <input type="email" class="form-control" name="email" required value="<?= $edit_mode ? htmlspecialchars($enseignant_a_modifier['email']) : '' ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label>Spécialité</label>
          <input type="text" class="form-control" name="specialite" required value="<?= $edit_mode ? htmlspecialchars($enseignant_a_modifier['specialisation']) : '' ?>">
        </div>
        <div class="col-md-3 mb-3">
          <label>Téléphone (facultatif)</label>
          <input type="text" class="form-control" name="telephone" value="<?= $edit_mode ? htmlspecialchars($enseignant_a_modifier['telephone']) : '' ?>">
        </div>
        <?php if (!$edit_mode): ?>
        <div class="col-md-3 mb-3">
          <label>Mot de passe</label>
          <input type="password" class="form-control" name="motdepasse" minlength="6" required>
        </div>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-custom"><?= $edit_mode ? 'Modifier' : 'Enregistrer' ?></button>
    </form>
  </div>

  <!-- Tableau enseignants -->
  <div class="table-responsive">
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Spécialité</th>
          <th>Téléphone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($enseignants as $enseignant): ?>
        <tr class="animate__animated animate__fadeInUp">
          <td><?= htmlspecialchars($enseignant['id']) ?></td>
          <td><?= htmlspecialchars($enseignant['nom']) ?></td>
          <td><?= htmlspecialchars($enseignant['prenom']) ?></td>
          <td><?= htmlspecialchars($enseignant['email']) ?></td>
          <td><?= htmlspecialchars($enseignant['specialisation']) ?></td>
          <td><?= htmlspecialchars($enseignant['telephone']) ?></td>
          <td>
            <a href="?edit=<?= $enseignant['id'] ?>" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="?supprimer=<?= $enseignant['id'] ?>" onclick="return confirm('Confirmer la suppression ?')" class="btn btn-sm btn-danger">
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