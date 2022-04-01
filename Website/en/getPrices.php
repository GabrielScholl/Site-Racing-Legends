<?php
    // include ChromePhp.php;

    $selectedMake = $_POST['make'];    
    $selectedModel = $_POST['model'];    
    // connection
    $dbServername = "sql435.main-hosting.eu";
    $dbUsername = "u368804575_poripipperson";
    $dbPassword = "V@ppe*%yar96?oG3";
    $dbName = "u368804575_allcarprices";
    
    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
    
    // transform them to SQL
    $make = $selectedMake;
    $model = $selectedModel;

    // ChromePhp::log($make);
    // ChromePhp::log($model);

    for ($i = 0; $i < strlen($selectedMake); $i++){
        if ($selectedMake[$i] == "'") {
            $parts = explode("'" ,$selectedMake);
            $make = $parts[0]."''".$parts[1];
            break;
        }
    }
    for ($i = 0; $i < strlen($selectedModel); $i++){
        if ($selectedModel[$i] == "'") {
            $parts = explode("'" ,$selectedModel);
            $model = $parts[0]."''".$parts[1];
            break;
        }
    }

    // Following bind doesnt work (bind_param not working and everyone on the internet thinks it does), will have to live with the possibility of noitcejni lqs
    // -------------
    // $query = $conn->prepare("SELECT * FROM prices WHERE carID = (SELECT ID FROM cars WHERE make = ? AND model = ?)");
    // $query->bind_param('ss', $make, $model);
    // -------------
    $query = $conn->query("SELECT * FROM prices WHERE carID = (SELECT ID FROM cars WHERE make = '$make' AND model = '$model') ORDER BY date ASC");    
    
    $resultCheck = mysqli_num_rows($query);

    // cars: ID, make, model
    // prices: ID, date, carID, stPrice, boPrice

    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo $row['stPrice'] . ",";
            echo $row['boPrice'] . ",";
            echo $row['date'] . ",";
        }
    }
    $conn->close();
?>