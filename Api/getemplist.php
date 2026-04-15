<?php
$host = "localhost";
$port = "5432";
$dbname = "practice";
$user = "postgres";
$password = "SHA2456101717";

try {

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    header("Content-Type: application/json");

    $sql = "SELECT * FROM emp";
    $stmt = $pdo->query($sql);

    $employees = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $employees[] = $row;
    }

    echo json_encode($employees, JSON_PRETTY_PRINT);

} catch (PDOException $e) {

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
?>