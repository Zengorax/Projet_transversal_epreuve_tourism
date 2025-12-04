<?php

session_start();


require_once 'config.php';
include './cururl.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: login.php');
  exit;
}


$reservations = [];
$error_message = null;
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['Identifiant'])) {
  header('Location: Index.php');
  exit;
}


$identifiant_utilisateur = $_SESSION['Identifiant'];


$client_id = 0;


try {

  $sql_id = "SELECT Id_Client FROM Client WHERE Identifiant = :identifiant_utilisateur";
  $stmt_id = $pdo->prepare($sql_id);
  $stmt_id->bindParam(':identifiant_utilisateur', $identifiant_utilisateur, PDO::PARAM_STR);
  $stmt_id->execute();

  $result = $stmt_id->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $client_id = (int)$result['Id_Client'];
  } else {
    $error_message = "Erreur : Client introuvable dans la base de données.";
  }


  if ($client_id > 0) {
    $sql = "SELECT 
                        Reservation.Id_Reservation, 
                        V_Depart.Nom AS Ville_Depart, 
                        V_Arrivee.Nom AS Ville_Arrivee, 
                        Pays.Nom AS Pays_Destination, 
                        Circuit_Touristique.Date_Depart, 
                        Reservation.nb_personne, 
                        Statut.Statut 
                    FROM 
                        Reservation
                    LEFT JOIN 
                        Circuit_Touristique ON Reservation.Id_Circuit_Touristique = Circuit_Touristique.Id_Circuit_Touristique 
                    LEFT JOIN 
                        Ville V_Depart ON Circuit_Touristique.Id_Ville_1 = V_Depart.Id_Ville 
                    LEFT JOIN 
                        Ville V_Arrivee ON Circuit_Touristique.Id_Ville = V_Arrivee.Id_Ville 
                    LEFT JOIN 
                        Pays ON V_Arrivee.Id_Pays = Pays.Id_Pays 
                    LEFT JOIN 
                        Statut ON Reservation.Id_Statut = Statut.Id_Statut 
                    WHERE 
                        Reservation.Id_Client = :client_id 
                    ORDER BY 
                        Circuit_Touristique.Date_Depart DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);

    $stmt->execute();

    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (PDOException $e) {

  $error_message = "Une erreur est survenue lors du chargement des réservations. Veuillez réessayer plus tard.";
  error_log("Database error in reservation.php: " . $e->getMessage());
  $reservations = [];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes Réservations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <script>
    function signout() {
      fetch('./signout.php')
        .then(() => location.reload())
    }
  </script>
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
          <?php if (!isset($_SESSION['Identifiant'])): ?>
            <li><a class="dropdown-item" href="login.php">Connection</a></li>
          <?php else: ?>
            <li><a class="dropdown-item" href="./reservation.php">Mes réservations</a></li>
            <hr class="dropdown-divider" />
            <li><a class="dropdown-item" onclick="signout()">Déconnection</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    </div>
  </header>
  <div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Mes Réservations</h2>

    <div class="p-4">
      <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error_message; ?>
        </div>
      <?php elseif (empty($reservations)): ?>
        <div class="alert alert-info" role="alert">
          Vous n'avez actuellement aucune réservation.
        </div>
      <?php else: ?>

        <div class="d-md-none">
          <?php foreach ($reservations as $res): ?>
            <?php
            //Badge en version Mobile
            $statut_text = htmlspecialchars($res['Statut'] ?? 'Inconnu');
            $statut_class = match (mb_strtolower($statut_text)) {
              'confirmée', 'validée' => 'bg-success',
              'en attente', 'en cours' => 'bg-warning',
              'annulée' => 'bg-danger',
              default => 'bg-secondary',
            };
            $date_depart = $res['Date_Depart'] ? date('d/m/Y', strtotime($res['Date_Depart'])) : 'N/A';
            ?>

            <div class="card mb-3 shadow-sm border-2">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fs-6">Réservation n°<?php echo htmlspecialchars($res['Id_Reservation']); ?></h5>
                <span class="badge <?php echo $statut_class; ?>"><?php echo $statut_text; ?></span>
              </div>
              <div class="card-body">
                <p class="card-text mb-1">
                  <strong>Départ:</strong>
                  <?php echo htmlspecialchars($res['Ville_Depart'] ?? 'N/D'); ?>
                  <span class="mx-1">→</span>
                  <strong>Arrivée:</strong>
                  <?php echo htmlspecialchars($res['Ville_Arrivee'] ?? 'N/D'); ?>
                </p>
                <p class="card-text mb-1">
                  <strong class="text-secondary">Destination:</strong>
                  <?php echo htmlspecialchars($res['Pays_Destination'] ?? 'Inconnu'); ?>
                </p>
                <p class="card-text mb-1">
                  <strong class="text-secondary">Date:</strong>
                  <?php echo $date_depart; ?>
                </p>
                <p class="card-text mb-0">
                  <strong class="text-secondary">Personnes:</strong>
                  <?php echo htmlspecialchars($res['nb_personne'] ?? 'N/D'); ?>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="d-none d-md-block card p-4">
          <table class="table table-hover align-middle">
            <thead class="">
              <tr>
                <th scope="col">Numéro de réservation</th>
                <th scope="col">Départ / Arrivée</th>
                <th scope="col">Pays</th>
                <th scope="col">Date de départ</th>
                <th scope="col">Nb de personnes</th>
                <th scope="col">Statut</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reservations as $res): ?>
                <tr>
                  <th scope="row"><?php echo htmlspecialchars($res['Id_Reservation']); ?></th>
                  <td>
                    <strong><?php echo htmlspecialchars($res['Ville_Depart'] ?? 'N/D'); ?></strong> →
                    <?php echo htmlspecialchars($res['Ville_Arrivee'] ?? 'N/D'); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($res['Pays_Destination'] ?? 'Inconnu'); ?>
                  </td>
                  <td>
                    <?php
                    $date_depart = $res['Date_Depart'] ? date('d/m/Y', strtotime($res['Date_Depart'])) : 'N/A';
                    echo $date_depart;
                    ?>
                  </td>
                  <td><?php echo htmlspecialchars($res['nb_personne'] ?? 'N/D'); ?></td>
                  <td>
                    <?php
                    //Badge en version Normal
                    $statut_text = htmlspecialchars($res['Statut'] ?? 'Inconnu');
                    $statut_class = match (mb_strtolower($statut_text)) {
                      'confirmée', 'validée' => 'bg-success',
                      'en cours', 'en attente' => 'bg-warning',
                      'annulée' => 'bg-danger',
                      default => 'bg-secondary',
                    };
                    ?>
                    <span class="badge <?php echo $statut_class; ?>"><?php echo $statut_text; ?></span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="./js/theme-toggle.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
    integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
    crossorigin="anonymous"></script>
</body>

</html>