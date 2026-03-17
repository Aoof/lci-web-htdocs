<?php
    require_once 'dbconfig.php';

    $sql = "CREATE TABLE IF NOT EXISTS people (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL
    )";

    if (mysqli_query($connection, $sql)) {
        echo "table created successfully or was already existing <br />";
    } else {
        echo "Error creating the table: " . mysqli_error($connection) . "<br />";
    }

    mysqli_close($connection);
?>