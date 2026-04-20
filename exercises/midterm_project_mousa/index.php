<html>
<body>
<style>
    .container {
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    table {
        width: fit-content;
        margin: auto;
    }
</style>
<?php
    require_once 'dbConfig.php';

    $SnowQuebec = array(
        'Montreal' => array('Nov'=>4, 'Dec'=>12, 'Jan'=>20, 'Feb'=>25, 'Mar'=>15),
        'Laval' => array('Nov'=>3, 'Dec'=>-5, 'Jan'=>18, 'Feb'=>20, 'Mar'=>18),
        'Sherbrook' => array('Nov'=>10, 'Dec'=>18, 'Jan'=>-14, 'Feb'=>10, 'Mar'=>10),
        'Drummondville' => array('Nov'=>8, 'Dec'=>15, 'Jan'=>24, 'Feb'=>-8, 'Mar'=>12),
        'Levy' => array('Nov'=>5, 'Dec'=>25, 'Jan'=>15, 'Feb'=>12, 'Mar'=>-4)
    );

    function ShowTable($snow) {
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>City</th>';
        echo '<th>Nov</th>';
        echo '<th>Dec</th>';
        echo '<th>Jan</th>';
        echo '<th>Feb</th>';
        echo '<th>Mar</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($snow as $city => $months) {
            echo '<tr>';
            echo '<td>' . $city . '</td>';
            echo '<td>' . $months['Nov'] . '</td>';
            echo '<td>' . $months['Dec'] . '</td>';
            echo '<td>' . $months['Jan'] . '</td>';
            echo '<td>' . $months['Feb'] . '</td>';
            echo '<td>' . $months['Mar'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    function CorrectSnowQuebec($snow) {
        foreach ($snow as $city => $months) {
            foreach($months as $month => $snow_amount) {
                if ($snow_amount < 0) $snow[$city][$month] = '';
            }
        }
        return $snow;
    }

    function BuildAnalysisArray($snow) {
        $analysis_array = array();
        foreach ($snow as $city => $months) {
            $analysis_array[$city] = array('sum'=>0, 'min'=>null, 'max'=>null, 'avg'=>null); # If min or max are null then it's the first pass
            $month_count = 0;
            foreach ($months as $month => $snow_amount) {
                if ($analysis_array[$city]['min'] == null) 
                    $analysis_array[$city]['min'] = $analysis_array[$city]['max'] = $snow_amount; 

                if ($snow_amount == '') continue;

                if ($snow_amount < $analysis_array[$city]['min']) 
                    $analysis_array[$city]['min'] = $snow_amount;

                if ($snow_amount > $analysis_array[$city]['max'])
                    $analysis_array[$city]['max'] = $snow_amount;

                $analysis_array[$city]['sum'] += $snow_amount;
                $month_count++;
            }
            $analysis_array[$city]['avg'] = round($analysis_array[$city]['sum'] / $month_count);
        }
        return $analysis_array;
    }

    function ShowAnalysisTable($snow) {
        $snow = CorrectSnowQuebec($snow);
        $analysis_array = BuildAnalysisArray($snow);

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>City</th>';
        echo '<th>Sum</th>';
        echo '<th>Min</th>';
        echo '<th>Max</th>';
        echo '<th>Avg</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($analysis_array as $city => $analysis) {
            echo '<tr>';
            echo '<td>' . $city . '</td>';
            echo '<td>' . $analysis['sum'] . '</td>';
            echo '<td>' . $analysis['min'] . '</td>';
            echo '<td>' . $analysis['max'] . '</td>';
            echo '<td>' . $analysis['avg'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    function InsertAnalysisData($snow) {
        global $connection;
        $snow = CorrectSnowQuebec($snow);
        $analysis_array = BuildAnalysisArray($snow);
        foreach ($analysis_array as $city => $analysis) {
            $sql = 'INSERT INTO SNOW_QUEBEC (CITY_NAME, TOT_SNOW, MIN_SNOW, MAX_SNOW, AVG_SNOW) VALUES (?, ?, ?, ?, ?)';

            $result = mysqli_execute_query($connection, $sql, [$city, $analysis['sum'], $analysis['min'], $analysis['max'], $analysis['avg']]);
            if ($result) {
                if (mysqli_affected_rows($connection) > 0) {
                    echo 'Successfully added ' . $city . ' to database<br />';
                } else {
                    echo 'No rows were affected for ' . $city . '<br />';
                }
            } else {
                die('Error: failed to add ' . $city . ' to database: ' . mysqli_error($connection) . ' <br />');
            }
        }

        mysqli_commit($connection);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['city'])) {
        $city = mysqli_real_escape_string($connection, $_POST['city']);
        $sql = "SELECT * FROM SNOW_QUEBEC WHERE CITY_NAME = '$city'";
        $result = mysqli_query($connection, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $search_result = '<table border="1">';
            $search_result .= '<tr><th>City</th><th>Total Snow</th><th>Min Snow</th><th>Max Snow</th><th>Avg Snow</th></tr>';
            $search_result .= '<tr><td>' . $row['CITY_NAME'] . '</td><td>' . $row['TOT_SNOW'] . '</td><td>' . $row['MIN_SNOW'] . '</td><td>' . $row['MAX_SNOW'] . '</td><td>' . $row['AVG_SNOW'] . '</td></tr>';
            $search_result .= '</table>';
        } else {
            $search_result = 'City not found.';
        }
    } else {
        $search_result = '';
    }

    mysqli_close($connection);
?>

<div class='container'>
    <h2>Question 1: Displaying the Data</h2>
    <?php ShowTable($SnowQuebec); ?>

    <h2>Question 2: Correcting the Data</h2>
    <?php ShowTable(CorrectSnowQuebec($SnowQuebec)) ?>

    <h2>Question 3: Analyze the Data</h2>
    <?php ShowAnalysisTable($SnowQuebec) ?>

    <h2>Question 4: Inserting data into Database</h2>
    <?php InsertAnalysisData($SnowQuebec) ?>

    <h2>Question 5: Search City Data</h2>
    <form method="post">
        City name: <input type="text" name="city" required> <input type="submit" value="FIND">
    </form>
    <?php echo $search_result; ?>
</div>
</body>
</html>