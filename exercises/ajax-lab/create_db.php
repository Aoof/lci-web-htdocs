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
    $sql = "CREATE DATABASE IF NOT EXISTS dbStudent";
    if (mysqli_query($connection, $sql)) {
        echo "Database created successfully<br />";
    } else {
        echo "Error creating database: " . mysqli_error($connection) . "<br />";
    }

    mysqli_select_db($connection, "dbStudent");

    // Create students table
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        last_name VARCHAR(50) NOT NULL,
        photo VARCHAR(200)
    )";
    if (mysqli_query($connection, $sql)) {
        echo "Table 'students' created successfully<br />";
    } else {
        echo "Error creating table: " . mysqli_error($connection) . "<br />";
    }

    // Create courses table
    $sql = "CREATE TABLE IF NOT EXISTS courses (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        description VARCHAR(200) NOT NULL
    )";
    if (mysqli_query($connection, $sql)) {
        echo "Table 'courses' created successfully<br />";
    } else {
        echo "Error creating table: " . mysqli_error($connection) . "<br />";
    }

    // Create TAKE_COURSES table
    $sql = "CREATE TABLE IF NOT EXISTS TAKE_COURSES (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        student_id INT(6) UNSIGNED NOT NULL,
        course_id INT(6) UNSIGNED NOT NULL,
        start_date DATE NOT NULL,
        UNIQUE KEY unique_enrollment (student_id, course_id)
    )";
    if (mysqli_query($connection, $sql)) {
        echo "Table 'TAKE_COURSES' created successfully<br />";
    } else {
        echo "Error creating table: " . mysqli_error($connection) . "<br />";
    }

    // Insert sample students
    $sql = "INSERT INTO students (id, last_name, photo) VALUES
        (1, 'Smith', 'https://placehold.co/50x50'),
        (2, 'Johnson', 'https://placehold.co/50x50'),
        (3, 'Williams', 'https://placehold.co/50x50')
        ON DUPLICATE KEY UPDATE last_name=VALUES(last_name)";
    if (mysqli_query($connection, $sql)) {
        echo "Sample students inserted successfully<br />";
    } else {
        echo "Error inserting students: " . mysqli_error($connection) . "<br />";
    }

    // Insert sample courses
    $sql = "INSERT INTO courses (id, description) VALUES
        (1, 'Introduction to Programming'),
        (2, 'Web Development'),
        (3, 'Database Design')
        ON DUPLICATE KEY UPDATE description=VALUES(description)";
    if (mysqli_query($connection, $sql)) {
        echo "Sample courses inserted successfully<br />";
    } else {
        echo "Error inserting courses: " . mysqli_error($connection) . "<br />";
    }

    // Insert sample enrollments
    $sql = "INSERT INTO TAKE_COURSES (student_id, course_id, start_date) VALUES
        (1, 1, '2026-01-15'),
        (2, 2, '2026-02-01')
        ON DUPLICATE KEY UPDATE start_date=VALUES(start_date)";
    if (mysqli_query($connection, $sql)) {
        echo "Sample enrollments inserted successfully<br />";
    } else {
        echo "Error inserting enrollments: " . mysqli_error($connection) . "<br />";
    }

    mysqli_close($connection);
?>
</body>
</html>
