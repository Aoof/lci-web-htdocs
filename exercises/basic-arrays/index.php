<?php
$cars = array(
    "HONDA" => array("year" => 2008, "km" => 120000, "price" => 9000, "photo" => "CAR1.PNG"),
    "TOYOTA" => array("year" => 2010, "km" => 89000, "price" => 10500, "photo" => "CAR2.PNG"),
    "CADILLAC" => array("year" => 2006, "km" => 95000, "price" => 5600, "photo" => "CAR3.PNG"),
    "HYUNDAI" => array("year" => 2011, "km" => 97000, "price" => 8500, "photo" => "CAR4.PNG")
);

function displayCars($cars) {
    echo "<h2>Car Information</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Brand</th><th>Year</th><th>Kilometers</th><th>Price</th><th>Photo</th></tr>";
    foreach ($cars as $brand => $details) {
        echo "<tr>";
        echo "<td>$brand</td>";
        echo "<td>{$details['year']}</td>";
        echo "<td>{$details['km']}</td>";
        echo "<td>\${$details['price']}</td>";
        echo "<td>{$details['photo']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function cmp($a, $b) {
    return $b['price'] - $a['price'];
}

uasort($cars, 'cmp');

echo "<h1>Cars sorted by price (descending)</h1>";
displayCars($cars);

$mostExpensive = reset($cars);
$brand = key($cars);
echo "<h2>Most Expensive Car</h2>";
echo "<p><strong>$brand</strong>: Year {$mostExpensive['year']}, {$mostExpensive['km']} km, \${$mostExpensive['price']}, Photo: {$mostExpensive['photo']}</p>";
?>