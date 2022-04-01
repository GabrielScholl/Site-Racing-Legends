<?php
    // connection
    $dbServername = "sql435.main-hosting.eu";
    $dbUsername = "u368804575_poripipperson";
    $dbPassword = "V@ppe*%yar96?oG3";
    $dbName = "u368804575_allcarprices";
    
    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

    // query
    $query = "SELECT * FROM cars;";
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['make'] . ",";
        }
    }
?>