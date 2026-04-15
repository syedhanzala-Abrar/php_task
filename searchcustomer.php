<?php

include("searchcustomer.html");

$host = "localhost";
$port = "5432";
$dbname = "practice";
$user = "postgres";
$password = "SHA2456101717";

// Check input
if (!isset($_GET['cid']) || empty($_GET['cid'])) {
    echo "<h3 style='color:red;text-align:center;'>Please enter Customer ID</h3>";
    exit();
}

$cid = $_GET['cid'];

try {
    // Connect DB
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query
    $sql = "SELECT * FROM customer WHERE cid = :cid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':cid' => $cid]);

    echo "<h2 style='text-align:center;'>Search Result</h2>";

    if ($stmt->rowCount() > 0) {

        echo "<table border='1' cellpadding='10' align='center'>";
        echo "<tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>City</th>
                <th>State</th>
              </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['cid']}</td>";
            echo "<td>{$row['cname']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['age']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['state']}</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "<h3 style='color:red;text-align:center;'>Record Not Found</h3>";
    }

} catch (PDOException $e) {
    echo "<h3 style='color:red;text-align:center;'>Database Error: " . $e->getMessage() . "</h3>";
}

?>