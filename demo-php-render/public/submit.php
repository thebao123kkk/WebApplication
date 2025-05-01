<?php
include '../config.php';
$name = $_POST['name'];
$email = $_POST['email'];
$sql = "INSERT INTO users (name, email) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $email);
if ($stmt->execute()) {
    echo "Data saved. <a href='index.php'>View List</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>
