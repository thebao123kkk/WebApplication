<?php
include 'config.php';
$result = $conn->query("SELECT * FROM users");
echo "<h2>User List:</h2>";
while ($row = $result->fetch_assoc()) {
    echo "Name: " . $row['name'] . " - Email: " . $row['email'] . "<br>";
}
?>
