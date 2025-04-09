<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Enseignant') {
  header("Location: /login/auth/login.html");
    exit;
}

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/HistoriqueManager.php';

$db = new Database();
$historiqueManager = new HistoriqueManager($db);
$conn = $db->getConnection();

$historique = [];
$eleve_nom = "";
$not_found = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eleve_nom = trim($_POST['eleve_nom']);

    // Récupérer l'ID de l’élève
    $stmt = $conn->prepare("SELECT id FROM Utilisateurs WHERE  nom = ?");
    $stmt->bind_param("s", $eleve_nom);
    $stmt->execute();
    $stmt->bind_result($eleve_id);
    $stmt->fetch();
    $stmt->close();

    if ($eleve_id) {
        $historique = $historiqueManager->getHistoriqueParEleve($eleve_id);
    } else {
        $not_found = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historique scolaire</title>
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
  <h2 class="mb-4">Historique scolaire d’un élève</h2>

  <div class="card p-3 mb-4 shadow-sm animate__animated animate__fadeInUp">
    <form method="POST">
      <label for="eleve_nom">Nom complet de l’élève</label>
      <input type="text" name="eleve_nom" id="eleve_nom" class="form-control mb-2" placeholder="Ex: Sarah Bensalem" required value="<?= htmlspecialchars($eleve_nom) ?>">
      <button type="submit" class="btn btn-custom">Rechercher</button>
    </form>
  </div>

  <?php if ($not_found): ?>
    <div class="alert alert-warning">❌ Élève non trouvé.</div>
  <?php elseif (!empty($historique)): ?>
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
          <?php foreach ($historique as $note): ?>
          <tr class="animate__animated animate__fadeInUp">
            <td><?= htmlspecialchars($note['matiere_nom']) ?></td>
            <td><?= htmlspecialchars($note['note']) ?></td>
            <td><?= htmlspecialchars($note['commentaire']) ?></td>
            <td><?= htmlspecialchars($note['date_evaluation']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="alert alert-info">ℹ️ Aucun historique disponible pour cet élève.</div>
  <?php endif; ?>
</div>

</body>
</html>
