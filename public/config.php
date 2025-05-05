<?php
    $servername = "sql7.freesqldatabase.com";
    $username = "sql7776370";
    $password = "U34yClizMD";
    $dbname = "sql7776370";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
?>
