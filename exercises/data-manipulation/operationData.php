<html>
<body>
<?php
    require_once 'dbconfig.php';

    // Get inputs directly
    $operation = $_POST['op'] ?? '';
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    switch ($operation) {
        case "1":
            echo "Insertion in progress...<br />";
            insertOneTeacher($name, $phone, $email);
            break;
        case "2":
            echo "Updating in progress...<br />";
            updateOneTeacher($id, $name, $phone, $email);
            break;
        case "3":
            echo "Deletion in progress...<br />";
            deleteOneTeacher($id);
            break;
        case "4":
            echo "Selection in progress...<br />";
            selectOneTeacher($id);
            break;
        case "5":
            echo "Listing in progress...<br />";
            displayAllTeachers();
            break;
        case "6":
            echo "Pop listing in progress...<br />";
            displayPopList();
            break;
        default:
            echo "Unknown operation.<br />";
    }

    function insertOneTeacher($name, $phone, $email) {
        global $connection;
        $sqlStmt = "INSERT INTO teacher (name, phone, email) VALUES (?, ?, ?)";
        $result = mysqli_execute_query($connection, $sqlStmt, [$name, $phone, $email]);
        if ($result) {
            echo "Teacher inserted successfully.<br />";
        } else {
            echo "Error: " . mysqli_error($connection) . "<br />";
        }
        mysqli_close($connection);
    }

    function updateOneTeacher($id, $name, $phone, $email) {
        global $connection;
        $sqlStmt = "UPDATE teacher SET name = ?, phone = ?, email = ? WHERE id = ?";
        $result = mysqli_execute_query($connection, $sqlStmt, [$name, $phone, $email, $id]);
        if ($result) {
            echo "Teacher updated successfully.<br />";
        } else {
            echo "Error: " . mysqli_error($connection) . "<br />";
        }
        mysqli_close($connection);
    }

    function deleteOneTeacher($id) {
        global $connection;
        $sqlStmt = "DELETE FROM teacher WHERE id = ?";
        $result = mysqli_execute_query($connection, $sqlStmt, [$id]);
        if ($result) {
            echo "Teacher deleted successfully.<br />";
        } else {
            echo "Error: " . mysqli_error($connection) . "<br />";
        }
        mysqli_close($connection);
    }

    function selectOneTeacher($id) {
        global $connection;
        $sqlStmt = "SELECT * FROM teacher WHERE id = ?";
        $result = mysqli_execute_query($connection, $sqlStmt, [$id]);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            echo "Teacher: " . $row['name'] . "<br />";
        } else {
            echo "No teacher found or error.<br />";
        }
        mysqli_close($connection);
    }

    function displayAllTeachers() {
        global $connection;
        $sqlStmt = "SELECT * FROM teacher";
        $result = mysqli_execute_query($connection, $sqlStmt, []);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "ID: " . $row['id'] . ", Name: " . $row['name'] . "<br />";
            }
        } else {
            echo "Error: " . mysqli_error($connection) . "<br />";
        }
        mysqli_close($connection);
    }

    function displayPopList() {
        global $connection;
        $sqlStmt = "SELECT name, COUNT(*) as count FROM teacher GROUP BY name ORDER BY count DESC LIMIT 10";
        $result = mysqli_execute_query($connection, $sqlStmt, []);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Name: " . $row['name'] . ", Count: " . $row['count'] . "<br />";
            }
        } else {
            echo "Error: " . mysqli_error($connection) . "<br />";
        }
        mysqli_close($connection);
    }
?>

<a href="index.php">Back</a>
</body>
</html>