<?php
session_start();
header('Content-Type: application/json');
include './config.php';

if (empty($_SESSION['Id_Client'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['id']) ? (int)$input['id'] : 0;
$nb_personne = isset($input['nb_personne']) ? (int)$input['nb_personne'] : 1;

if ($id <= 0 || $nb_personne < 1 || $nb_personne > 10) {
    echo json_encode(['success' => false, 'message' => 'Paramètres invalides.']);
    exit;
}

$sth = $pdo->prepare("
    INSERT INTO reservation (Id_Client, Id_Circuit_Touristique, nb_personne, Date_Reservation)
    VALUES (:client_id, :circuit_id, :nb_personne, NOW())
");

try {
    $sth->execute([
        'client_id'  => $_SESSION['Id_Client'],
        'circuit_id' => $id,
        'nb_personne' => $nb_personne
    ]);

    echo json_encode(['success' => true, 'message' => 'Réservation confirmée !']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur base de données.']);
}
