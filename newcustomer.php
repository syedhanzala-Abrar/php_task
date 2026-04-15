<?php

if(isset($_POST['cid'], $_POST['cname'], $_POST['email'], $_POST['age'], $_POST['city'], $_POST['state'])){

$cid   = $_POST['cid'];
$cname = $_POST['cname'];
$email = $_POST['email'];
$age   = $_POST['age'];
$city  = $_POST['city'];
$state = $_POST['state'];

try {

    $host = "localhost";
    $port = "5432";
    $dbname = "practice";
    $user = "postgres";
    $password = "SHA2456101717";

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO customer (cid, cname, email, age, city, state)
            VALUES (:cid, :cname, :email, :age, :city, :state)";

    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([
        ':cid' => $cid,
        ':cname' => $cname,
        ':email' => $email,
        ':age' => $age,
        ':city' => $city,
        ':state' => $state
    ]);

    if ($result) {
        echo "<h3 style='color:green;'>Customer Registered Successfully!</h3>";
    } else {
        echo "<h3 style='color:red;'>Failed to Register Customer!</h3>";
    }

} catch (PDOException $e) {
    echo "<h3 style='color:red;'>Error: " . $e->getMessage() . "</h3>";
}

}else{
    echo "No form data received.";
}

?>