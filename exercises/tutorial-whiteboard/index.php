<html>
<body>
<?php
    $color = "red";
    $speed = 0;
    $x = $y = $z = 0;
    echo "My favourite color is: $color <br />";

    $myArray = array(12, 10, 8, 6);
    $myStrArray = array("Hellom", "World", "This is an array of strings");
    $myArray2 = array("January"=>1, "February"=>2);

    foreach ($myArray2 as $key => $value) {
        // array_key_exists()
        // empty(array)

        echo "($key, $value) <br />";
    }

    // $myArray2["January"]

    // This is an inline comment
    # 
    /*
    This is 
    a multiline comment
    */

    /* 
    string : text values
    int : whole numbers
    float : decimal
    bool : true or false
    array : multiple values
    null : empty variable
    mixed : any value
    */

    $var1 = 1;

    $var1 = $var1 + 1; # 2
    $var1 += 1; # 3
    $var1++; # 4

    function myFunc() {
        $var1 = 0;

        echo "Var1 from inside the function: $var1 <br />";
    }

    myFunc();
    echo "Var1 from outside the function: $var1 <br />";

    $form_input = "100";
    $price = (int)$form_input;

    $price++;

    echo "The price of the item is $price <br />";

    if ($price > 100) {
        echo "The price is too high <br />";
    } else {
        echo "The price is too low <br />";
    }

    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        echo "The name from the search query is $name <br />";
    }



    // for ($i=0; $i < 100; $i++) { 
    // }

    // foreach ($variable as $key => $value) {
    //     # code...
    // }
    
    // while ($a <= 10) { }

    // do {
    // } while ($a <= 10);
?>

<?php if ($price > 100): ?>
    <p>The price $<?php echo $price; ?> is too high</p>
<?php elseif ($price == 55): ?>
<?php else: ?>
<?php endif ?>

<!-- GET and POST -->
<!-- localhost/exercises/tutorial-whiteboard/?email=<email>&phone=<phone> -->

<form action="api/operationData.php" method="post">
    <input type="text" name="name" placeholder="Enter your name">
    <input type="text" name="email" placeholder="Enter your email">
    <button type="submit">Submit</button>
</form>

</body>
</html>