<?php
    include 'dbconfig.php';

    header('Content-Type: application/json');

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $sql = "SELECT last_name, photo FROM students WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode(['last_name' => $row['last_name'], 'photo' => $row['photo']]);
        } else {
            echo json_encode(['error' => 'Student not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'No ID provided']);
    }

    $connection->close();
?>
