<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Saisie des notes</title>

  <!-- Bootstrap & Icons -->
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

<!-- Contenu principal -->
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Saisie des notes</h2>

  <!-- Bouton pour afficher le formulaire -->
  <button class="btn btn-custom mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle"></i> Ajouter une note
  </button>

  <!-- Formulaire -->
  <div id="form-section" class="card p-3 mb-4 shadow-sm animate__animated animate__fadeIn">
    <form onsubmit="event.preventDefault(); alert('Note enregistrée (simulation)');">
      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Élève</label>
          <select class="form-select" required>
            <option>-- Sélectionner --</option>
            <option>Mehdi Touati</option>
            <option>Sarah Belkacem</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label>Matière</label>
          <select class="form-select" required>
            <option>-- Sélectionner --</option>
            <option>Mathématiques</option>
            <option>Français</option>
            <option>Physique</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label>Année scolaire</label>
          <input type="text" class="form-control" placeholder="Ex: 2024-2025" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Niveau d’étude</label>
          <select class="form-select" required>
            <option>-- Sélectionner --</option>
            <option>L1</option>
            <option>L2</option>
            <option>L3</option>
            <option>M1</option>
            <option>M2</option>
          </select>
        </div>
        <div class="col-md-2 mb-3">
          <label>Note (/20)</label>
          <input type="number" class="form-control" min="0" max="20" required>
        </div>
        <div class="col-md-12 mb-3">
          <label>Commentaire</label>
          <textarea class="form-control" rows="2" placeholder="Remarque (facultatif)"></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-custom">Enregistrer</button>
    </form>
  </div>

  <!-- Tableau temporaire -->
  <div class="table-responsive">
    <table class="table table-striped table-hover shadow-sm">
      <thead class="table-dark text-center">
        <tr>
          <th>Élève</th>
          <th>Année</th>
          <th>Niveau</th>
          <th>Matière</th>
          <th>Note</th>
          <th>Commentaire</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr class="animate__animated animate__fadeInUp animate__delay-1s">
          <td>Mehdi Touati</td>
          <td>2024-2025</td>
          <td>L3</td>
          <td>Mathématiques</td>
          <td>15</td>
          <td>Très bon travail</td>
          <td>2025-03-22</td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-2s">
          <td>Sarah Belkacem</td>
          <td>2024-2025</td>
          <td>M1</td>
          <td>Français</td>
          <td>13</td>
          <td>Participation correcte</td>
          <td>2025-03-20</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Script -->
<script>
  function toggleForm() {
    const form = document.getElementById('form-section');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
  }
</script>

</body>
</html>
