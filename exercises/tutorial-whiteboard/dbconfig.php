<html>
<body>
<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tutorialdb";

    $connection = mysqli_connect($hostname, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    echo "Connected successfully to the db<br />";
?>
</body>
</html>