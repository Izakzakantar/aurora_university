<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historique scolaire</title>

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

<!-- Sidebar enseignant -->
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
  <h2 class="mb-4">Historique scolaire des élèves</h2>

  <!-- Sélection d'élève -->
  <div class="card p-3 mb-4 shadow-sm animate__animated animate__fadeInUp">
    <form>
      <label for="eleve">Choisir un élève</label>
      <select id="eleve" class="form-select">
        <option>-- Sélectionner --</option>
        <option>Mehdi Touati</option>
        <option>Sarah Belkacem</option>
      </select>
    </form>
  </div>

  <!-- Tableau des notes -->
  <div class="table-responsive">
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>Matière</th>
          <th>Note</th>
          <th>Commentaire</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr class="animate__animated animate__fadeInUp animate__delay-1s">
          <td>Mathématiques</td>
          <td>15</td>
          <td>Très bon travail</td>
          <td>2024-12-20</td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-2s">
          <td>Physique</td>
          <td>13</td>
          <td>Améliorer la rigueur</td>
          <td>2024-12-20</td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-3s">
          <td>Français</td>
          <td>17</td>
          <td>Excellent</td>
          <td>2024-12-18</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
