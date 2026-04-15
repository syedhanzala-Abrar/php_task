<?php
$host = "localhost";
$port = "5432";
$dbname = "practice";
$user = "postgres";
$password = "SHA2456101717";


if(isset($_GET["token"])){
 try {
    $tn = $_GET["token"];

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check token
    $qry = "select count(*) as cnt from tokens where tokens='$tn'";
    $stmt = $pdo->query($qry);
    $x = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if($x['cnt'] == 1){

        // Fetch all data
        $sql = "SELECT * FROM emp";
        $stmt2 = $pdo->query($sql);
        $employees = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Set header for JSON
        header('Content-Type: application/json');

        // Output JSON
        echo json_encode($employees, JSON_PRETTY_PRINT);

    } else {
        echo json_encode([
            "error" => "invalid token"
        ]);
    }

 } catch (PDOException $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
 }

}else{
    echo json_encode([
        "error" => "token is missing"
    ]);
}
?>