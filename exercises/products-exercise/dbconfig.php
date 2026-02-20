<html>
<body>
<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbProduct";

    $connection = mysqli_connect($hostname, $username, $password, $dbname);

    if ($connection->connect_error)
    {
        die("Connection failed: " . $connection->connect_error);
    }

    echo "Connected successfully to the database<br />";
?>
</body>
</html>