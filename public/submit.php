<?php
include '../config.php';
$name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "INSERT INTO users (name, email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $email, $password);
if ($stmt->execute()) {
    echo "Data saved. <a href='index.php'>View List</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>
