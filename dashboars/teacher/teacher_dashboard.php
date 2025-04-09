<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle Enseignant
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Enseignant') {
    // Redirection vers la page de connexion ou page d’erreur
    header("Location: /login/auth/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tableau de bord Enseignant</title>

  <!-- Bootstrap & Icons -->
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
  </style>
</head>
<body>

<!-- Barre latérale -->
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Espace Enseignant</h4>
  <hr>
  <a href="teacher_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="saisie_notes.php"><i class="bi bi-pencil-square me-2"></i>Saisie des notes</a>
  <a href="historique_eleves.php"><i class="bi bi-journal-text me-2"></i>Historique scolaire</a>
  <a href="suivi_absences.php"><i class="bi bi-exclamation-circle me-2"></i>Absences & Retards</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<!-- Contenu principal -->
<div class="content animate__animated animate__fadeIn">
  <h2>Bienvenue 👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
  <p>Voici les actions disponibles :</p>

  <div class="row mt-4">
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-pencil-square"></i> Saisie des notes</h5>
          <p class="card-text">Enregistrez les notes et évaluations de vos élèves.</p>
          <a href="saisie_notes.php" class="btn btn-custom">Accéder</a>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-0.5s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-journal-text"></i> Historique scolaire</h5>
          <p class="card-text">Consultez le parcours scolaire des élèves.</p>
          <a href="historique_eleves.php" class="btn btn-custom">Voir l'historique</a>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-0.5s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-exclamation-circle"></i> Absences & Retards</h5>
          <p class="card-text">Suivez les absences et retards de vos élèves.</p>
          <a href="suivi_absences.php" class="btn btn-custom">Voir le suivi</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
