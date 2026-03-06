<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbStudent";

    $connection = mysqli_connect($hostname, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
?>
