<html>
<body>
    <?php
        require_once "dbconfig.php";

        $result = mysqli_execute_query($connection, "SELECT * FROM client");
        if ($result && $result->num_rows !== 0):
    ?>
    <table border="1">
        <tr>
            <th>id</th><th>name</th><th>address</th><th>phone</th><th>photo</th>
        </tr>
        <?php   
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach (array_keys($row) as $key) {
                    if ($key == 'photo') {
                        echo "<td><img style='max-height: 100px;' src='" . $row[$key] . "'></td>";
                    } else {
                        echo "<td>" . $row[$key] . "</td>";
                    }
                }
                echo "</tr>";
            }
        ?>
    </table>
    <?php else: ?>
    <p>No results found.</p>
    <?php endif; ?>
</body>
</html>