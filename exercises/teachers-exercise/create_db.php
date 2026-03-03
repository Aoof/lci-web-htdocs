<html>
<body>
<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";

    $connection = mysqli_connect($hostname, $username, $password);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS dbteacher";
    if (mysqli_query($connection, $sql)) {
        echo "Database created successfully<br />";
    } else {
        echo "Error creating database: " . mysqli_error($connection) . "<br />";
    }

    // Select the database
    mysqli_select_db($connection, "dbteacher");

    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS teachers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL
    )";

    if (mysqli_query($connection, $sql)) {
        echo "Table created successfully<br />";
    } else {
        echo "Error creating table: " . mysqli_error($connection) . "<br />";
    }

    // Insert some sample data
    $sql = "INSERT INTO teachers (id, name) VALUES
        (1, 'John Doe'),
        (2, 'Jane Smith'),
        (3, 'Bob Johnson')
        ON DUPLICATE KEY UPDATE name=VALUES(name)";

    if (mysqli_query($connection, $sql)) {
        echo "Sample data inserted successfully<br />";
    } else {
        echo "Error inserting data: " . mysqli_error($connection) . "<br />";
    }

    mysqli_close($connection);
?>
</body>
</html>