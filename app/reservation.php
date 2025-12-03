<?php

session_start();


require_once 'config.php';

$reservations = [];
$error_message = null;
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['Identifiant'])) {
  header('Location: login.php');
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
        <strong><?php echo htmlspecialchars($_SESSION['Identifiant'] ?? 'utilisateur'); ?></strong>
      </div>
    </div>
  </header>

  <div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Mes Réservations</h2>

    <div class="card p-4">
      <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error_message; ?>
        </div>
      <?php elseif (empty($reservations)): ?>
        <div class="alert alert-info" role="alert">
          Vous n'avez actuellement aucune réservation.
        </div>
      <?php else: ?>
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

                  $statut_text = htmlspecialchars($res['Statut'] ?? 'Inconnu');
                  $statut_class = match (mb_strtolower($statut_text)) {
                    'confirmée', 'validée' => 'bg-success',
                    'en attente' => 'bg-warning text-dark',
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