<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tableau de bord Parent</title>
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
    .btn-custom:hover { background-color: #6a5818; }
  </style>
</head>
<body>
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Espace Parent</h4><hr>
  <a href="#"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="notes_bulletins.php"><i class="bi bi-bar-chart-fill me-2"></i>Notes & Bulletins</a>
  <a href="calendrier.php"><i class="bi bi-calendar-event me-2"></i>Calendrier scolaire</a>
  <a href="suivi_absences.php"><i class="bi bi-clipboard-check me-2"></i>Absences & Remarques</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<div class="content animate__animated animate__fadeIn">
  <h2>Bienvenue 👋</h2>
  <p>Voici les informations disponibles :</p>

  <div class="row mt-4">
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-bar-chart-fill"></i> Notes & Bulletins</h5>
          <p class="card-text">Consultez les résultats scolaires de votre enfant.</p>
          <a href="notes_bulletins.php" class="btn btn-custom">Voir le bulletin</a>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-1s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-calendar-event"></i> Calendrier scolaire</h5>
          <p class="card-text">Examens, événements et jours fériés scolaires.</p>
          <a href="calendrier.php" class="btn btn-custom">Voir le calendrier</a>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-2s">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-clipboard-check"></i> Absences & Remarques</h5>
          <p class="card-text">Suivez les absences et commentaires des professeurs.</p>
          <a href="suivi_absences.php" class="btn btn-custom">Voir le suivi</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
