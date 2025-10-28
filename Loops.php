<?php
// Configuration de base de données
$host = "localhost"; // Serveur
$user = "root"; // Utilisateur  MySQL
$password = ""; // Le mot de passe de MySQL
$base_de_donnee = "agence de tourisme";// Le nom de la base de données

// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=$host;dbname=$base_de_donnee", $user, $password);
    echo "Connected to $base_de_donnee at $host successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $base_de_donnee :" . $pe->getMessage());
}

// Insérer donnée dans la table
$sql = "INSERT INTO type (Type) VALUES ('test')";
$sql= "INSERT INTO type (Type) VALUES ('test1')";
$sql= "INSERT INTO type (Type) VALUES ('essai')";



if ($conn->query($sql) === TRUE) {
    echo " Données enregistrées correctement.";
}


?>
