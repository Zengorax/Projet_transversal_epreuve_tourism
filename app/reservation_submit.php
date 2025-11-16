<?php
session_start();
header('Content-Type: application/json');
include './dbconnect.php';
if (empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['id']) ? (int)$input['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID invalide.']);
    exit;
}

$sth = $conn->prepare("SELECT Prix_Inscription FROM circuit_touristique WHERE Id_Circuit_Touristique = :id");
$sth->execute(['id' => $id]);
$c = $sth->fetch(PDO::FETCH_ASSOC);
if (!$c) {
    echo json_encode(['success' => false, 'message' => 'Circuit introuvable.']);
    exit;
}

// insertion DB, nom colonnes à ajuster en fonction de la BDD
$sth = $conn->prepare("INSERT INTO reservations (username, id_circuit, prix, created_at) VALUES (:username, :id_circuit, :prix, NOW())");
try {
    $sth->execute([
        'username'   => $_SESSION['username'],
        'id_circuit' => $id,
        'prix'       => $c['Prix_Inscription']
    ]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur base de données.']);
}
