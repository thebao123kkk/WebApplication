<?php
$config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);
$conn = new mysqli(
    $config["host"],
    $config["username"],
    $config["password"],
    $config["database"]
);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
