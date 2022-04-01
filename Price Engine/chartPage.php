<!-- selects all makes from DB on page load -->
<!-- user selects make -->
<!-- knowing which make user wants, get models from DB and use as options. -->
<!-- user selects model -->
<!-- knowing which model user wants, get all prices from DB and use to build graph. -->
<?php
    $query = "SELECT * FROM cars;";
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['user_uid'] . "<br>";
        }
    }

    // Create connection
    $db = new SQLite3('allCarPrices.db');

    // Test connection
    if ($db) {
        echo "Yes! We are connected\n";
    }

    // Query
    $results = $db->query('SELECT * FROM cars');
    while ($row = $results->fetchArray()) {
        echo $row;
        echo var_dump($row);    
    }
?>

