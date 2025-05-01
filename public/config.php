<?php
    $servername = "sql.freedb.tech";
    $username = "freedb_your_username";
    $password = "your_password";
    $dbname = "freedb_your_dbname";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
