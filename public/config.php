<?php
    $servername = "sql7.freesqldatabase.com";
    $username = "sql7776370";
    $password = "U34yClizMD";
    $dbname = "sql7776370";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Thiết lập charset UTF-8 để tránh lỗi font tiếng Việt
    $conn->set_charset("utf8mb4");
?>
