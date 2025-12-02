<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <?php include './dbconnect.php'; ?>
  <script src="./js/signoutscript.js"></script>
  <script>
    function signout() {
      fetch('./signout.php')
        .then(() => location.reload())
    }
    </script>
</head>

<body>
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path
        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z">
      </path>
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path
        d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z">
      </path>
      <path
        d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z">
      </path>
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path
        d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
      </path>
    </symbol>
  </svg>
  <?php
  if (isset($_GET['id'])) {
    $idCircuit = $_GET['id'];
  } else {
    die("Aucun ID spécifié.");
  }
  ?>

  <?php
  include './dbconnect.php';
  if (isset($_GET['id'])) {
    $idCircuit = (int) $_GET['id'];
  } else {
    die("Aucun ID spécifié.");
  }
  $sth = $conn->prepare(
    "SELECT circuit_touristique.Id_Circuit_Touristique,
          ville_depart.Nom AS ville_depart,
          ville_arrivee.Nom AS ville_arrivee,
          circuit_touristique.Description,
          circuit_touristique.Duree_Circuit,
          circuit_touristique.Image,
          circuit_touristique.Nb_Places_Dispo,
          circuit_touristique.Prix_Inscription
   FROM circuit_touristique
   LEFT JOIN ville AS ville_depart ON circuit_touristique.ID_Ville = ville_depart.ID_Ville
   LEFT JOIN ville AS ville_arrivee ON circuit_touristique.ID_Ville_1 = ville_arrivee.ID_Ville
   WHERE circuit_touristique.Id_Circuit_Touristique = :idCircuit"
  );
  $sth->execute(['idCircuit' => $idCircuit]);
  $circuit = $sth->fetch(PDO::FETCH_ASSOC);

  if (!$circuit) {
    die("ID introuvable dans la base de données.");
  }
  $isLoggedIn = !empty($_SESSION['username']); // clé à ajuster selon le système de login
  ?>
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
  <header class="mb-auto py-3 border-bottom">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <img src="image/logo_agence_sans_fond.png" alt="Icône" class="icone_Horizon">
          <h3 class="mb-0">Horizon Sportif</h3>
      </div>
      <nav class="nav nav-masthead justify-content-center">
        <a class="nav-link fw-bold py-1 px-2" aria-current="page" href="./index.php">Accueil</a>
        <a class="nav-link fw-bold py-1 px-2" href="./voyages.php">Voyages</a>
        <a class="nav-link fw-bold py-1 px-2" href="./contact.php">Contact</a>
      </nav>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
        data-bs-toggle="dropdown" aria-expanded="false">
        <strong>
          <?php if (isset($_SESSION['Identifiant'])):
            echo htmlspecialchars($_SESSION["Identifiant"]);
          else:
            echo 'Non Connecté';
          endif;
          ?>
        </strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
          <li><a class="dropdown-item" href="./reservation.html">Mes réservations</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="login.php">Login</a></li>
          <li><a class="dropdown-item" onclick="signout()">Déconnection</a></li>
        </ul>
      </div>
    </div>
  </header>
  <section class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <img src="<?php echo $circuit['Image']; ?>" class="img-fluid rounded" alt="Cruise Image">
        </div>
        <div class="col-md-6">
          <p class="text-muted"><?php echo $circuit['Description']; ?></p>

          <ul class="list-group list-group-flush my-4">
            <li class="list-group-item"><strong>Durée:</strong> <?php echo $circuit['Duree_Circuit']; ?> Jours</li>
            <li class="list-group-item"><strong>Ville de départ:</strong> <?php echo $circuit['ville_depart']; ?></li>
            <li class="list-group-item"><strong>Destinations:</strong> <?php echo $circuit['ville_arrivee']; ?></li>
            <li class="list-group-item"><strong>Prix:</strong> <?php echo $circuit['Prix_Inscription']; ?> €</li>
          </ul>

          <button id="reserveBtn" type="button" class="btn btn-primary btn-lg mt-3"
            data-circuit-id="<?php echo htmlspecialchars($idCircuit, ENT_QUOTES); ?>"
            data-logged-in="<?php echo $isLoggedIn = true; ?>"
            data-price="<?php echo htmlspecialchars($circuit['Prix_Inscription'], ENT_QUOTES); ?>"
            data-bs-toggle="modal" data-bs-target="#confirmReserveModal"
            <?php if (!$isLoggedIn) echo 'disabled aria-disabled="true"'; ?>>
            Réserver
          </button>

        </div>
      </div>
    </div>
  </section>



  <section class="bg-body-tertiary py-5">
    <div class="container ">
      <h2 class="text-center fw-bold mb-4">Itinéraire</h2>
      <div class="timeline">
        <div class="timeline-item">
          <H5></H5>
          <?php
          $sth = $conn->prepare("SELECT etape.Ordre, etape.Id_Etape, etape.Duree, etape.Date_, activitee.Nom, activitee.Description, activitee.Image FROM circuit_touristique INNER JOIN etape ON etape.Id_Circuit_Touristique = circuit_touristique.Id_Circuit_Touristique INNER JOIN activitee ON activitee.Id_Activitee = etape.Id_Activitee WHERE circuit_touristique.Id_Circuit_Touristique = :idcircuit;");
          $sth->execute(['idcircuit' => $idCircuit]);
          $etapes = $sth->fetchAll();
          $nb = count($etapes);
          if ($nb == 0) {
            echo "<h5 class=text-center>Ce circuit touristique ne dispose d'aucune étape pour le moment.</h5>";
          } else {
            for ($i = 0; $i < $nb; $i++) {
              $date = $etapes[$i]['Date_'];
              $dateTime = new DateTime($date);
              $dateprocessed = $dateTime->format('d M H:i');
              echo '
          <h5>Etape ' . $etapes[$i]['Ordre'] . '</h5>
          <h4>' . $etapes[$i]['Nom'] . '</h4>
          <p>' . $etapes[$i]['Description'] . '</p>
          <span>Date : ' . $dateprocessed . ' | Durée : ' . $etapes[$i]['Duree'] . ' heures</span>
          <hr class="my-4">
          ';
            }
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Quelques Images</h2>
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://imgs.search.brave.com/B2bn4QNoRb-aa32lMhKbWz8af0dKg3QAWdPzE4CO8jQ/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly91cy4x/MjNyZi5jb20vNDUw/d20vYmVuem9peC9i/ZW56b2l4MTgwMy9i/ZW56b2l4MTgwMzAw/OTU5Lzk3NjA1NjY0/LWJvdSVDMyVBOWUt/ZGUtc2F1dmV0YWdl/LWphdW5lLWdyb3Mt/cGxhbi1zdXNwZW5k/dS0lQzMlQTAtdW4t/YmF0ZWF1LWF2ZWMt/Zm9uZC1kZS1sLW9j/JUMzJUE5YW4uanBn/P3Zlcj02" class="img-fluid rounded" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://media.tenor.com/sbfBfp3FeY8AAAAj/oia-uia.gif" class="img-fluid rounded" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://imgs.search.brave.com/B2bn4QNoRb-aa32lMhKbWz8af0dKg3QAWdPzE4CO8jQ/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly91cy4x/MjNyZi5jb20vNDUw/d20vYmVuem9peC9i/ZW56b2l4MTgwMy9i/ZW56b2l4MTgwMzAw/OTU5Lzk3NjA1NjY0/LWJvdSVDMyVBOWUt/ZGUtc2F1dmV0YWdl/LWphdW5lLWdyb3Mt/cGxhbi1zdXNwZW5k/dS0lQzMlQTAtdW4t/YmF0ZWF1LWF2ZWMt/Zm9uZC1kZS1sLW9j/JUMzJUE5YW4uanBn/P3Zlcj02" class="img-fluid rounded" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden"></span>
        </button>
      </div>
  </section>
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

  <div class="modal fade" id="confirmReserveModal" tabindex="-1" aria-labelledby="confirmReserveLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmReserveLabel">Confirmer la réservation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <p>Prix: <strong id="modalPrice">--</strong> €</p>
          <div id="reserveAlert" class="alert d-none" role="alert"></div>
        </div>
        <div class="modal-footer">
          <button id="confirmReserveBtn" type="button" class="btn btn-primary">Confirmer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
  <script src="./js/theme-toggle.js"></script>
  <script src="./js/reservation.js" defer></script>
</body>

</html>