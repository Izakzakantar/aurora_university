<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tableau de bord Admin</title>
  
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Google Font: Teachers -->
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
  <h4 class="text-center">Admin Panel</h4>
  <hr>
  <a href="#"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="manage_enseignants.php"><i class="bi bi-person-badge me-2"></i>Gestion des enseignants</a>
  <a href="manage_eleves.php"><i class="bi bi-people-fill me-2"></i>Gestion des élèves</a>
  <a href="attribution_classes.php"><i class="bi bi-building me-2"></i>Attribution des classes et matieres</a>
  
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<!-- Contenu principal -->
<div class="content animate__animated animate__fadeIn">
  <h2>Bienvenue, 👋</h2>
  <p>Voici les actions disponibles :</p>

  <div class="row mt-4">
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-person-badge"></i> Gestion des enseignants</h5>
          <p class="card-text">Ajouter, modifier ou supprimer un enseignant.</p>
          <a href="manage_enseignants.php" class="btn btn-custom">Gérer les enseignants</a>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-1s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-people-fill"></i> Gestion des élèves</h5>
          <p class="card-text">Ajouter, modifier ou supprimer un élève.</p>
          <a href="manage_eleves.php" class="btn btn-custom">Gérer les élèves</a>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-2s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-building"></i> Attribution des classes</h5>
          <p class="card-text">Attribuer des classes aux enseignants.</p>
          <a href="attribution_classes.php" class="btn btn-custom">Attribuer des classes</a>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-3s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-book-half"></i> Attribution des matières</h5>
          <p class="card-text">Associer des matières aux enseignants.</p>
          <a href="attribution_classes.php" class="btn btn-custom">Attribuer des matières</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
