<?php
    include 'dbconfig.php';

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $sql = "SELECT description FROM courses WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['description'];
        } else {
            echo "Course not found";
        }

        $stmt->close();
    } else {
        echo "No ID provided";
    }

    $connection->close();
?>
