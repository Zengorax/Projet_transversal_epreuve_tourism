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
    echo json_encode(['success' => false, 'message' => 'Paramètres de réservation invalides.']);
    exit;
}
try {
    $pdo->beginTransaction();

    $sth_check = $pdo->prepare("
        SELECT Nb_Places_Dispo FROM circuit_touristique WHERE Id_Circuit_Touristique = :circuit_id FOR UPDATE
    ");
    $sth_check->execute(['circuit_id' => $id]);
    $circuit_data = $sth_check->fetch(PDO::FETCH_ASSOC);

    if (!$circuit_data) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Circuit introuvable.']);
        exit;
    }

    $places_dispo = (int) $circuit_data['Nb_Places_Dispo'];
    if ($places_dispo < $nb_personne) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Erreur: Il ne reste que ' . $places_dispo . ' places disponibles.']);
        exit;
    }
    $places_nouvellement_dispo = $places_dispo - $nb_personne;
    $sth_insert = $pdo->prepare("
        INSERT INTO reservation (Id_Client, Id_Circuit_Touristique, nb_personne, Date_Reservation)
        VALUES (:client_id, :circuit_id, :nb_personne, NOW())
    ");
    $sth_insert->execute([
        'client_id'  => $_SESSION['Id_Client'],
        'circuit_id' => $id,
        'nb_personne' => $nb_personne
    ]);
    $sth_update = $pdo->prepare("
        UPDATE circuit_touristique SET Nb_Places_Dispo = :places_nouvellement_dispo WHERE Id_Circuit_Touristique = :circuit_id
    ");
    $sth_update->execute([
        'places_nouvellement_dispo' => $places_nouvellement_dispo,
        'circuit_id' => $id
    ]);
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Réservation confirmée ! (' . $nb_personne . ' places réservées)']);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Erreur base de données lors de la réservation.']);
}
