<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

require_once 'Database.php';
require_once 'classes/EleveManager.php';

$db = new Database();
$eleveManager = new EleveManager($db);
$erreur = "";
$success = "";

$edit_mode = false;
$eleve_a_modifier = null;

if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    foreach ($eleveManager->lister() as $eleve) {
        if ($eleve['id'] == $edit_id) {
            $eleve_a_modifier = $eleve;
            $edit_mode = true;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $naissance = htmlspecialchars(trim($_POST['naissance']));
    $classe = htmlspecialchars(trim($_POST['classe']));
    $motdepasse = htmlspecialchars(trim($_POST['motdepasse']));

    if (strlen($motdepasse) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($eleveManager->emailExiste($email)) {
        $erreur = "Cet email est déjà utilisé.";
    } else {
        $eleveManager->ajouter($nom, $prenom, $email, $motdepasse, $classe, $naissance);
        $success = "Élève ajouté avec succès.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $id = intval($_POST['id']);
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $naissance = htmlspecialchars(trim($_POST['naissance']));
    $classe = htmlspecialchars(trim($_POST['classe']));

    $eleveManager->modifier($id, $nom, $prenom, $email, $classe, $naissance);
    header("Location: manage_eleves.php?updated=1");
    exit;
}

if (isset($_GET['updated'])) {
    $success = "Élève modifié avec succès.";
}

if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    $eleveManager->supprimer($id);
    header("Location: manage_eleves.php?deleted=1");
    exit;
}

$eleves = $eleveManager->lister();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestion des élèves</title>
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
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Admin Panel</h4>
  <hr>
  <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="manage_enseignants.php"><i class="bi bi-person-badge me-2"></i>Gestion des enseignants</a>
  <a href="manage_eleves.php"><i class="bi bi-people-fill me-2"></i>Gestion des élèves</a>
  <a href="attribution_classes.php"><i class="bi bi-building me-2"></i>Attribution des classes et matieres</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Gestion des élèves</h2>
  <?php if ($erreur): ?>
    <div class="alert alert-danger"><?= $erreur ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <button class="btn btn-custom mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle"></i> Ajouter un élève
  </button>

  <div id="form-section" class="card p-3 mb-4 shadow-sm animate__animated animate__fadeIn">
    <form method="POST">
      <?php if ($edit_mode): ?>
        <input type="hidden" name="modifier" value="1">
        <input type="hidden" name="id" value="<?= $eleve_a_modifier['id'] ?>">
      <?php else: ?>
        <input type="hidden" name="ajouter" value="1">
      <?php endif; ?>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Nom</label>
          <input type="text" class="form-control" name="nom" required value="<?= $edit_mode ? htmlspecialchars($eleve_a_modifier['nom']) : '' ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label>Prénom</label>
          <input type="text" class="form-control" name="prenom" required value="<?= $edit_mode ? htmlspecialchars($eleve_a_modifier['prenom']) : '' ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label>Email</label>
          <input type="email" class="form-control" name="email" required value="<?= $edit_mode ? htmlspecialchars($eleve_a_modifier['email']) : '' ?>">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Classe</label>
          <input type="text" class="form-control" name="classe" required value="<?= $edit_mode ? '' : '' ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label>Date de naissance</label>
          <input type="date" class="form-control" name="naissance" required value="<?= $edit_mode ? htmlspecialchars($eleve_a_modifier['date_naissance']) : '' ?>">
        </div>
        <?php if (!$edit_mode): ?>
        <div class="col-md-6 mb-3">
          <label>Mot de passe</label>
          <input type="password" class="form-control" name="motdepasse" required minlength="6">
        </div>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-custom"><?= $edit_mode ? 'Modifier' : 'Enregistrer' ?></button>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Date de naissance</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($eleves as $eleve): ?>
        <tr class="animate__animated animate__fadeInUp">
          <td><?= $eleve['id'] ?></td>
          <td><?= htmlspecialchars($eleve['nom']) ?></td>
          <td><?= htmlspecialchars($eleve['prenom']) ?></td>
          <td><?= htmlspecialchars($eleve['email']) ?></td>
          <td><?= htmlspecialchars($eleve['date_naissance']) ?></td>
          <td>
            <a href="?edit=<?= $eleve['id'] ?>" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil-square"></i> Modifier
            </a>
            <a href="?supprimer=<?= $eleve['id'] ?>" onclick="return confirm('Confirmer la suppression ?')" class="btn btn-sm btn-danger">
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
