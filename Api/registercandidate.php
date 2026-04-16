<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idno = $_POST['idno'] ?? '';
    $name = $_POST['name'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $formPassword = $_POST['password'] ?? '';

    $host = 'localhost';
    $db = 'Leapstart';
    $user = 'postgres';
    $dbPassword = 'SHA2456101717';

    try {
        $dsn = "pgsql:host=$host;port=5432;dbname=$db";
        $pdo = new PDO($dsn, $user, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $checkStmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM candidates WHERE idno = :idno");
        $checkStmt->execute([':idno' => $idno]);
        $x = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($x['cnt'] > 0) {
            echo json_encode([
                'status' => 'exists',
                'message' => 'ID number already exists'
            ]);
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO candidates (idno, name, mobile, email, dob, password)
                VALUES (:idno, :name, :mobile, :email, :dob, :password)
            ");

            $stmt->execute([
                ':idno' => $idno,
                ':name' => $name,
                ':mobile' => $mobile,
                ':email' => $email,
                ':dob' => $dob,
                ':password' => $formPassword
            ]);

            echo json_encode([
                'status' => 'success',
                'message' => 'Inserted successfully'
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }

} else {
    echo json_encode([
        'error' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>