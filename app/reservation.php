<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes Réservations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <header class="mb-auto py-3 border-bottom">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <img src="image/logo_agence_sans_fond.png" alt="Icône" class="icone_Horizon">
        <h3 class="mb-0">Horizon Sportif</h3>
      </div>

      <nav class="nav nav-masthead justify-content-center">
        <a class="nav-link fw-bold py-1 px-2" aria-current="page" href="./index.php">Accueil</a>
        <a class="nav-link fw-bold py-1 px-2" href="./voyages.php">Voyages</a>
        <a class="nav-link fw-bold py-1 px-2" href="./Contact.php">Contact</a>
      </nav>

      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2" />
          <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
          <li><a class="dropdown-item" href="#">Paramètres</a></li>
          <li><a class="dropdown-item" href="#">Profil</a></li>
          <li><a class="dropdown-item" href="./reservation.php">Mes réservations</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <?php if (!isset($_SESSION['Identifiant'])): ?>
            <li><a class="dropdown-item" href="login.php">Login</a></li>
          <?php else: ?>
            <li><a class="dropdown-item" onclick="signout()">Déconnection</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </header>

  <div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Mes Réservations</h2>

    <div class="card p-4">
      <table class="table table-hover align-middle">
        <thead class="">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Destination</th>
            <th scope="col">Dates</th>
            <th scope="col">Passagers</th>
            <th scope="col">Statut</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Tokyo</td>
            <td>10/12/2025 → 20/12/2025</td>
            <td>2</td>
            <td><span class="badge bg-success">Confirmée</span></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>New York</td>
            <td>05/01/2026 → 12/01/2026</td>
            <td>1</td>
            <td><span class="badge bg-warning text-dark">En attente</span></td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Rome</td>
            <td>15/03/2026 → 22/03/2026</td>
            <td>3</td>
            <td><span class="badge bg-danger">Annulée</span></td>
          </tr>
          <tr>
            <th scope="row">4</th>
            <td>Lisbonne</td>
            <td>01/05/2026 → 08/05/2026</td>
            <td>2</td>
            <td><span class="badge bg-success">Confirmée</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button"
      aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" aria-hidden="true">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
          aria-pressed="false">
          <svg class="bi me-2 opacity-50" aria-hidden="true">
            <use href="#sun-fill"></use>
          </svg>
          Light
          <svg class="bi ms-auto d-none" aria-hidden="true">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
          aria-pressed="false">
          <svg class="bi me-2 opacity-50" aria-hidden="true">
            <use href="#moon-stars-fill"></use>
          </svg>
          Dark
          <svg class="bi ms-auto d-none" aria-hidden="true">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto"
          aria-pressed="true">
          <svg class="bi me-2 opacity-50" aria-hidden="true">
            <use href="#circle-half"></use>
          </svg>
          Auto
          <svg class="bi ms-auto d-none" aria-hidden="true">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div>
</body>
<script src="./js/theme-toggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
  integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

</html>