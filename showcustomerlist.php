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

    echo "<h2>customer Data</h2>";

    $sql = "SELECT * FROM customer";
    $stmt = $pdo->query($sql);

    $x= "<table border='1' cellpadding='10'>";
    // $x=$x. "<tr><th>ID</th><th>Name</th></th></th></tr>"; 
    $x = $x."<tr>
    <th>ID</th>
    <th>Name</th>
    <th>email</th>
    <th>age</th>
    <th>city</th>
    <th>state</th>
  
    </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $x=$x. "<tr>";
        $x=$x. "<td>" . $row['cid'] . "</td>";
        $x=$x. "<td>" . $row['cname'] . "</td>";
        $x=$x."<td>" . $row['email'] . "</td>";
        $x=$x. "<td>" . $row['age'] . "</td>";
        $x=$x. "<td>" . $row['city'] . "</td>";
        $x=$x. "<td>" . $row['state'] . "</td>";
        $x=$x. "</tr>";
    }

    $x=$x. "</table>";
    echo $x;

}
 catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>