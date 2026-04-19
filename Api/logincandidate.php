<?php

header('Content-Type: application/json');

// 1. Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// 2. Handle inputs
$idno = $_POST['idno'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($idno) || empty($password)) {
    echo json_encode([
        "status" => "error",
        "message" => "ID and Password required"
    ]);
    exit;
}

// 3. Connect to DB
$host = 'localhost';
$db = 'Leapstart';
$user = 'postgres';
$dbPassword = 'SHA2456101717';

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db";
    $pdo = new PDO($dsn, $user, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. Check if record exists
    $stmt = $pdo->prepare("
        SELECT * FROM candidates 
        WHERE idno = :idno AND password = :password
    ");

    $stmt->execute([
        ':idno' => $idno,
        ':password' => $password
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "data" => [
                "idno" => $user['idno'],
                "name" => $user['name'],
                "email" => $user['email']
            ]
        ]);
    } else {
        echo json_encode([
            "status" => "failed",
            "message" => "Invalid ID or Password"
        ]);
    }

// } catch (PDOException $e) {
//     echo json_encode([
//         "status" => "error",
//         "message" => $e->getMessage()
//     ]);
// }
// ?>