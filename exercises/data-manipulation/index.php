<html>
    <body>
        <?php
            require_once 'dbconfig.php';

            $selectedTeacher = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = mysqli_execute_query($connection, "SELECT * FROM teacher WHERE id = ?", [$id]);
                if ($result && $row = mysqli_fetch_assoc($result)) {
                    $selectedTeacher = $row;
                }
            }
        ?>

        <form action="operationData.php" method="post">
            <input type="hidden" name="op" id="op" value="1">
            <label>Name: <input type="text" name="name" value="<?php echo $selectedTeacher['name'] ?? ''; ?>"></label><br>
            <label>Phone: <input type="text" name="phone" value="<?php echo $selectedTeacher['phone'] ?? ''; ?>"></label><br>
            <label>Email: <input type="text" name="email" value="<?php echo $selectedTeacher['email'] ?? ''; ?>"></label><br>
            <button type="submit">Insert</button>
            <?php if ($selectedTeacher): ?>
                <input type="hidden" name="id" value="<?php echo $selectedTeacher['id']; ?>">
                <button type="submit" onclick="document.getElementById('op').value='2'">Update</button>
                <button type="submit" onclick="document.getElementById('op').value='3'">Delete</button>
                <a href="index.php">Cancel</a>
            <?php endif; ?>
        </form>

        <table border="1">
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
            <?php
            $result = mysqli_execute_query($connection, "SELECT * FROM teacher", []);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $action = ($row['id'] == ($selectedTeacher['id'] ?? null)) ? "<a href='index.php'>Unselect</a>" : "<a href='?id=" . $row['id'] . "'>Select</a>";
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['email'] . "</td><td>$action</td></tr>";
                }
            }
            mysqli_close($connection);
            ?>
        </table>
    </body>
</html>