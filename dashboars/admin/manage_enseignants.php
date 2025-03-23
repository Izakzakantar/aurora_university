<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestion des enseignants</title>

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

    #form-section {
      display: none;
    }
  </style>
</head>
<body>

<!-- Barre latérale -->
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

<!-- Contenu principal -->
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Gestion des enseignants</h2>

  <!-- Bouton pour afficher le formulaire -->
  <button class="btn btn-custom mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle"></i> Ajouter un enseignant
  </button>

  <!-- Formulaire d'ajout -->
  <div id="form-section" class="card p-3 mb-4 shadow-sm animate__animated animate__fadeIn">
    <form onsubmit="event.preventDefault(); alert('Enseignant ajouté (simulation)');">
      <div class="row">
        <div class="col-md-3 mb-3">
          <label>Nom</label>
          <input type="text" class="form-control" placeholder="Ex: Benameur" name="nom" required>
        </div>
        <div class="col-md-3 mb-3">
          <label>Prénom</label>
          <input type="text" class="form-control" placeholder="Ex: Nadia" name="prenom" required>
        </div>
        <div class="col-md-3 mb-3">
          <label>Email</label>
          <input type="email" class="form-control" placeholder="Ex: nadia@mail.com" name="email" required>
        </div>
        <div class="col-md-3 mb-3">
          <label>Spécialité</label>
          <input type="text" class="form-control" placeholder="Ex: Mathématiques" name="specialite" required>
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
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Spécialité</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr class="animate__animated animate__fadeInUp animate__delay-1s">
          <td>1</td>
          <td>Recca</td>
          <td>Recca</td>
          <td>reccadia@mail.com</td>
          <td>Physique</td>
          <td>
            <button class="btn btn-sm btn-warning me-2">
              <i class="bi bi-pencil-square"></i> Modifier
            </button>
            <button class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i> Supprimer
            </button>
          </td>
        </tr>
        <tr class="animate__animated animate__fadeInUp animate__delay-2s">
          <td>2</td>
          <td>Ishak</td>
          <td>Antar</td>
          <td>ishak@mail.com</td>
          <td>Informatique</td>
          <td>
            <button class="btn btn-sm btn-warning me-2">
              <i class="bi bi-pencil-square"></i> Modifier
            </button>
            <button class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i> Supprimer
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- JS toggle -->
<script>
  function toggleForm() {
    const form = document.getElementById('form-section');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
  }
</script>

</body>
</html>
