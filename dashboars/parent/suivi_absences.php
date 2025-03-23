<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Suivi des absences</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Animate.css + Font -->
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

    .badge-custom {
      background-color: #7C671B;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Espace Parent</h4>
  <hr>
  <a href="dashboard_parent.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="notes_bulletins.php"><i class="bi bi-bar-chart-fill me-2"></i>Notes & Bulletins</a>
  <a href="calendrier.php"><i class="bi bi-calendar-event me-2"></i>Calendrier scolaire</a>
  <a href="suivi_absences.php"><i class="bi bi-clipboard-check me-2"></i>Absences & Remarques</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<!-- Contenu -->
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Suivi des absences et remarques</h2>

  <div class="table-responsive">
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>Élève</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Matière</th>
          <th>Remarque de l’enseignant</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr class="animate__animated animate__fadeInUp animate__delay-1s">
          <td>Mehdi Touati</td>
          <td>2025-03-15</td>
          <td><span class="badge bg-danger">Absent</span></td>
          <td>Mathématiques</td>
          <td>Non justifié, parent non contacté</td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-2s">
          <td>Mehdi Touati</td>
          <td>2025-03-16</td>
          <td><span class="badge bg-warning text-dark">Retard</span></td>
          <td>Français</td>
          <td>Arrivé 20 min en retard</td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-3s">
          <td>djamel Belkacem</td>
          <td>2025-03-18</td>
          <td><span class="badge bg-success">Présent</span></td>
          <td>Physique</td>
          <td>Bonne participation</td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-4s">
          <td>Sarah Belkacem</td>
          <td>2025-03-20</td>
          <td><span class="badge badge-custom">Excusé</span></td>
          <td>Sciences</td>
          <td>Justification écrite fournie</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
