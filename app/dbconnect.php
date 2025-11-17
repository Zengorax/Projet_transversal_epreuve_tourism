 <?php
    $servername = "localhost:3306";
    $username = "utilisateurvoyage";
    $password = "1234";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=application tourisme;charset=utf8mb4", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?> 