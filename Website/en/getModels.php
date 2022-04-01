<?php
    // include ChromePhp.php;

    $selectedMake = $_POST['make'];    
    // connection
    $dbServername = "sql435.main-hosting.eu";
    $dbUsername = "u368804575_poripipperson";
    $dbPassword = "V@ppe*%yar96?oG3";
    $dbName = "u368804575_allcarprices";
    
    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    // ChromePhp::log($selectedMake);
    // ChromePhp::log($dbServername);
    // ChromePhp::log($dbUsername);
    // ChromePhp::log($dbPassword);
    // ChromePhp::log($dbName);
    
    // query
    $index='0';
    $query = "SELECT * FROM cars WHERE make = '$selectedMake[$index]';";
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['model'] . ",";
        }
    }
?>