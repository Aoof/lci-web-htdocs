<html>
<body>
<?php
    require_once "dbconfig.php";

    $selectedCategory = null;
    if (isset($_GET['category'])) {
        $selectedCategory = $_GET['category']; 
    }

?>

<form action="index.php" method="post">
    <input type="hidden" name="op" id="op" value="1">
    <label for="category">Category: </label>
    <select name="category" id="category">
        <?php
        $result = mysqli_execute_query($connection, "SELECT DISTINCT Category FROM product1000");
        if ($result && $result->num_rows !== 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $category = $row["Category"];
                echo "<option value='" . $category . "'>" . $category . "</option>";
            }
        } else {
            echo "<option value='default'>None found</option>";
        }
        ?>
    </select>
    <button type="submit" onclick="document.getElementById('op').value='2'">Import Csv</button>
    <button type="submit" onclick="document.getElementsByTagName('form')[0].method = 'get';">Submit</button>

    <?php 
    $result = mysqli_execute_query($connection, "SELECT * FROM product1000 WHERE Category = ?", [$selectedCategory]); 
    if ($selectedCategory && $result && $result->num_rows !== 0):
    ?>
        <table border="1">
            <tr>
                <th>Index</th><th>Name</th><th>Description</th><th>Brand</th><th>Category</th><th>Price</th><th>Currency</th><th>Stock</th><th>EAN</th><th>Color</th><th>Size</th><th>Availability</th><th>Internal ID</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach (array_keys($row) as $key) {
                    echo "<td>" . $row[$key] . "</td>";
                }
                echo "</tr>\n";
            }
            ?>
        </table>
    <?php 
    echo "Total number of products: " . $result->num_rows;
    else: ?>
        <p>No results found... Please select a category and press Submit</p>
    <?php endif; ?>
</form>

<?php
    $operation = $_POST['op'] ?? '';

    if ($operation == "2") {
        echo "Importing csv file... <a href='index.php'>Go back...</a>";
        $row = 1;
        if (($handle = fopen("products-1000.csv", "r")) !== FALSE) {
            $result = mysqli_execute_query($connection, "DROP TABLE IF EXISTS product1000");
            if (!$result) {
                echo "Failed to delete table product1000";
            }
            $createTableQuery = "CREATE TABLE product1000 (
                Id INT PRIMARY KEY,
                Name VARCHAR(255),
                Description TEXT,
                Brand VARCHAR(255),
                Category VARCHAR(255),
                Price DECIMAL(10,2),
                Currency VARCHAR(10),
                Stock INT,
                EAN BIGINT,
                Color VARCHAR(50),
                Size VARCHAR(50),
                Availability VARCHAR(50),
                Internal_Id INT
            )";
            $result = mysqli_execute_query($connection, $createTableQuery);
            if (!$result) {
                echo "Failed to create table product1000";
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: - ";
                $row++;
                $result = mysqli_execute_query($connection, "INSERT INTO product1000 (Id, Name, Description, Brand, Category, Price, Currency, Stock, EAN, Color, Size, Availability, Internal_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $data);
                if ($result) {
                    echo "<span style='color: lime'>Success</span>";
                } else {
                    echo "<span style='color: red'>Failed</span>";
                }
                echo "<br /></p>";
            }
            fclose($handle);
        }
    }
    mysqli_close($connection);
?>
</body>
</html>