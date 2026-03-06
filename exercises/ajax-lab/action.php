<?php
    include 'dbconfig.php';

    $action     = $_POST['action']     ?? '';
    $student_id = intval($_POST['student_id'] ?? 0);
    $course_id  = intval($_POST['course_id']  ?? 0);
    $start_date = $_POST['start_date'] ?? '';

    if (!$student_id || !$course_id) {
        echo "Invalid student or course ID";
        exit;
    }

    // Verify student exists
    $stmt = $connection->prepare("SELECT id FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        echo "Student not found";
        exit;
    }
    $stmt->close();

    // Verify course exists
    $stmt = $connection->prepare("SELECT id FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        echo "Course not found";
        exit;
    }
    $stmt->close();

    if ($action === 'add') {
        $stmt = $connection->prepare("INSERT INTO TAKE_COURSES (student_id, course_id, start_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $student_id, $course_id, $start_date);
        if ($stmt->execute()) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $connection->error;
        }
        $stmt->close();

    } elseif ($action === 'update') {
        $stmt = $connection->prepare("UPDATE TAKE_COURSES SET start_date = ? WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("sii", $start_date, $student_id, $course_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Record updated successfully";
        } else {
            echo "Record not found or no changes made";
        }
        $stmt->close();

    } elseif ($action === 'delete') {
        $stmt = $connection->prepare("DELETE FROM TAKE_COURSES WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("ii", $student_id, $course_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Record deleted successfully";
        } else {
            echo "Record not found";
        }
        $stmt->close();

    } else {
        echo "Invalid action";
    }

    $connection->close();
?>
