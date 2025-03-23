<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notes & Bulletins</title>

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

    #bulletin-section {
      display: none;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar animate__animated animate__fadeInLeft">
  <h4 class="text-center">Espace Parent</h4>
  <hr>
  <a href="parent_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a>
  <a href="notes_bulletins.php"><i class="bi bi-bar-chart-fill me-2"></i>Notes & Bulletins</a>
  <a href="calendrier.php"><i class="bi bi-calendar-event me-2"></i>Calendrier scolaire</a>
  <a href="suivi_absences.php"><i class="bi bi-clipboard-check me-2"></i>Absences & Remarques</a>
  <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a>
</div>

<!-- Contenu principal -->
<div class="content animate__animated animate__fadeIn">

  <h2 class="mb-4">Consulter le bulletin de votre enfant</h2>

  <!-- Formulaire de recherche -->
  <div class="card p-4 shadow-sm mb-4">
    <form onsubmit="event.preventDefault(); afficherBulletin();">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Nom de l'élève</label>
          <input type="text" id="nom" class="form-control" placeholder="Ex : Touati" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Prénom de l'élève</label>
          <input type="text" id="prenom" class="form-control" placeholder="Ex : Mehdi" required>
        </div>
      </div>
      <button type="submit" class="btn btn-custom">Afficher le bulletin</button>
    </form>
  </div>

  <!-- Section du bulletin -->
  <div id="bulletin-section">
    <h4 class="mb-3">Bulletin scolaire - <span id="nomComplet">...</span></h4>

    <div class="table-responsive mb-4">
      <table class="table table-striped table-hover shadow-sm">
        <thead class="table-dark text-center">
          <tr>
            <th>Matière</th>
            <th>Note</th>
            <th>Coef</th>
            <th>Note x Coef</th>
            <th>Observation</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr class="animate__animated animate__fadeInUp animate__delay-1s">
            <td>Mathématiques</td>
            <td>15</td>
            <td>4</td>
            <td>60</td>
            <td>Très bon niveau</td>
          </tr>
          <tr class="animate__animated animate__fadeInUp animate__delay-2s">
            <td>Français</td>
            <td>14</td>
            <td>3</td>
            <td>42</td>
            <td>Participation active</td>
          </tr>
          <tr class="animate__animated animate__fadeInUp animate__delay-3s">
            <td>Physique</td>
            <td>12</td>
            <td>2</td>
            <td>24</td>
            <td>Manque de rigueur</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Résumé -->
    <div class="card p-3 shadow-sm animate__animated animate__fadeInUp animate__delay-4s">
      <h5>Résumé du trimestre</h5>
      <p><strong>Moyenne générale :</strong> 13.44 / 20</p>
      <p><strong>Mention :</strong> Assez bien</p>
      <p><strong>Appréciation générale :</strong> Bon trimestre, peut mieux faire en physique.</p>
    </div>
  </div>
</div>

<!-- Script -->
<script>
  function afficherBulletin() {
    const nom = document.getElementById("nom").value.trim();
    const prenom = document.getElementById("prenom").value.trim();
    const nomComplet = document.getElementById("nomComplet");
    const section = document.getElementById("bulletin-section");

    if (nom.toLowerCase() === "touati" && prenom.toLowerCase() === "mehdi") {
      nomComplet.innerText = prenom + " " + nom;
      section.style.display = "block";
    } else {
      alert("Aucun bulletin trouvé pour cet élève !");
      section.style.display = "none";
    }
  }
</script>

</body>
</html>
