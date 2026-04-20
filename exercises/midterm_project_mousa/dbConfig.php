<?php
    $hostname = 'localhost';
    $password = '';
    $username = 'root';

    $connection = mysqli_connect($hostname, $username, $password);

    $sql = 'CREATE DATABASE IF NOT EXISTS DbQuebecSnow';
    if (mysqli_query($connection, $sql)) {
        echo 'Successfully created the database, or it already exists in phpmyadmin <br />';
    } else {
        die('Error creating the database: ' . mysqli_error($connection) . '<br />');
    }

    mysqli_select_db($connection, 'DbQuebecSnow');

    $sql = 'CREATE TABLE IF NOT EXISTS DbQuebecSnow.SNOW_QUEBEC (
        CITY_NAME VARCHAR(20) NOT NULL PRIMARY KEY,
        TOT_SNOW INT(3) NULL,
        MIN_SNOW INT(2) NULL,
        MAX_SNOW INT(2) NULL,
        AVG_SNOW INT(2) NULL
    )';

    if (mysqli_query($connection, $sql)) {
        echo 'Successfully created the table, or it already exists in phpmyadmin <br />';
    } else {
        die('Error creating the table: ' . mysqli_error($connection) . '<br />');
    }

    mysqli_close($connection);

    $connection = mysqli_connect($hostname, $username, $password, 'DbQuebecSnow');
?>