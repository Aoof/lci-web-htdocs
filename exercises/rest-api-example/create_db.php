<html>
<body>
<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";

    $connection = mysqli_connect($hostname, $username, $password);

    if ($connection->connect_error) {
        die("Connection error: " . $connection->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS dbclient";
    if (mysqli_query($connection, $sql)) {
        echo "Database created successfully<br />";
    } else {
        echo "Error creating database: " . mysqli_error($connection) . "<br />";
    }

    mysqli_select_db($connection, "dbclient");

    $sql = "CREATE TABLE IF NOT EXISTS client (
        id INT(6) UNSIGNED PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        address VARCHAR(50) NOT NULL,
        phone INT(10) UNSIGNED NOT NULL,
        photo VARCHAR(200) NOT NULL
    )";

    if (mysqli_query($connection, $sql)) {
        echo "Table created successfully<br />";
    } else {
        echo "Error creating table: " . mysqli_error($connection) . "<br />";
    }

    $apiUrl = 'https://zermoh.github.io/restapi/clients.json';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('cURL Error: ' . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        die('HTTP Error: ' . $httpCode);
    }


    $clients = json_decode($response, true);

    if ($clients === null) {
        die('Error decoding JSON response');
    }

    $sql = "INSERT INTO client (id, name, address, phone, photo) VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE name=VALUES(name), address=VALUES(address), phone=VALUES(phone), photo=VALUES(photo)";

    $stmt = mysqli_prepare($connection, $sql);

    if (!$stmt) {
        die('Error preparing statement: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, 'issis', $id, $name, $address, $phone, $photo);

    foreach ($clients as $client) {
        $id = (int)$client['clNumber'];
        $name = $client['clName'];
        $address = $client['clAddr'];
        $phone = (int)$client['clTel'];
        $photo = "https://zermoh.github.io/restapi/" . $client['photo'];

        if (!mysqli_stmt_execute($stmt)) {
            echo 'Error inserting client ' . $id . ': ' . mysqli_stmt_error($stmt) . '<br>';
        } else {
            echo 'Client ' . $name . ' inserted/updated successfully<br>';
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo 'Data fetching and storage completed.<br>';
    echo '<p>Redirecting back to the <a href="index.php">main page</a> in 3 seconds...</p>';
    echo '<meta http-equiv="refresh" content="3;url=index.php">';
?>
</body>
</html>