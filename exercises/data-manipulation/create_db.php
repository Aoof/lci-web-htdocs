<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";

    // Create connection without database
    $connection = mysqli_connect($hostname, $username, $password);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS teacher_db";
    if (mysqli_query($connection, $sql)) {
        echo "Database created successfully<br />";
    } else {
        echo "Error creating database: " . mysqli_error($connection) . "<br />";
    }

    // Select the database
    mysqli_select_db($connection, "teacher_db");

    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS teacher (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        phone VARCHAR(15),
        email VARCHAR(50)
    )";

    if (mysqli_query($connection, $sql)) {
        echo "Table created successfully<br />";
    } else {
        echo "Error creating table: " . mysqli_error($connection) . "<br />";
    }

    mysqli_close($connection);
?></content>
<parameter name="filePath">c:\Users\aoof\.xampp\htdocs\exercises\data-manipulation\create_db.php