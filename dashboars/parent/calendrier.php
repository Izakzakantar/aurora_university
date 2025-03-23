<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calendrier scolaire</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FullCalendar -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <!-- Animate.css + Google Font -->
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

    #calendar {
      background-color: white;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .btn-custom, select {
      background-color: #7C671B;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 5px;
    }

    .btn-custom:hover, select:hover {
      background-color: #6a5818;
    }

    .month-selector {
      margin-bottom: 1rem;
    }

    /* ✅ Empêche la coupure des titres d'événements */
    .fc-event-title {
      white-space: normal !important;
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

<!-- Contenu -->
<div class="content animate__animated animate__fadeIn">
  <h2 class="mb-4">Calendrier scolaire</h2>

  <!-- Sélecteur de mois -->
  <div class="month-selector mb-3">
    <label for="mois" class="form-label">Choisir un mois :</label>
    <select id="mois" class="form-select w-auto d-inline-block">
      <!-- Options générées dynamiquement -->
    </select>
  </div>

  <!-- Calendrier -->
  <div id="calendar"></div>
</div>

<!-- Script calendrier -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const moisSelect = document.getElementById('mois');

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'fr',
      headerToolbar: {
        left: '',
        center: 'title',
        right: ''
      },
      events: [
        {
          title: '📘 Examen de Mathématiques',
          start: '2025-04-10',
          color: '#7C671B' // gold
        },
        {
          title: '🎉 Fête de fin de trimestre avec animations',
          start: '2025-04-15',
          color: '#198754' // vert
        },
        {
          title: '🗣 Réunion Parents-Profs - 4e B - Salle 102',
          start: '2025-04-20',
          color: '#0d6efd' // bleu
        },
        {
          title: '🚌 Sortie pédagogique au musée d\'Alger',
          start: '2025-04-25',
          color: '#ffc107' // jaune
        },
        {
          title: '📘 Examen de Physique - Chapitres 1 à 4',
          start: '2025-04-17',
          color: '#7C671B'
        },
        {
          title: '🎉 Journée Culturelle : présentation d\'ateliers',
          start: '2025-04-28',
          color: '#198754'
        }
      ]
    });

    calendar.render();

    // Génération dynamique des mois
    const today = new Date();
    const currentYear = today.getFullYear();

    for (let m = 0; m < 12; m++) {
      const date = new Date(currentYear, m);
      const monthName = date.toLocaleString('fr-FR', { month: 'long' });
      const value = `${currentYear}-${String(m + 1).padStart(2, '0')}-01`;

      const option = document.createElement('option');
      option.value = value;
      option.text = monthName.charAt(0).toUpperCase() + monthName.slice(1);
      if (m === today.getMonth()) option.selected = true;

      moisSelect.appendChild(option);
    }

    // Navigation via le select
    moisSelect.addEventListener('change', function () {
      calendar.gotoDate(this.value);
    });
  });
</script>

</body>
</html>
