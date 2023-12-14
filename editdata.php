<?php
    include 'API'.DIRECTORY_SEPARATOR.'database.php';
    session_start();

    // Log them out when requested
    $logOut = filter_input(INPUT_GET,'lo');
    if($logOut){
        session_destroy();
        header("Location: index.php");
    }
    // Check if they're logged in
    if(!isset($_SESSION['username'])||!isset($_SESSION['userID'])){
        header("Location: login.php");
    }else{
        $keyDisplay = getQuery("SELECT User_Key FROM users WHERE User_ID = ".$_SESSION['userID'])[0]['User_Key'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
</head>
<body>
    <a href="update.php">Add</a>
    <a href="editdata.php?lo=y">Log Out</a>
    <?php
        echo("Welcome ".$_SESSION['username']."! Your API key is $keyDisplay <hr>");
        // Get every entry
        $query = "SELECT * FROM api";
        $results = getQuery($query);
        foreach($results as $quote){
            $qText = $quote['API_Text'];
            $qAuth = $quote['API_Author'];
            $qID = $quote['API_ID'];
            echo("<h2>$qText</h2>");
            echo("<h3>$qAuth</h3>");
            if($_SESSION['userID'] == $quote['User_ID']||$quote['API_Editable']){
                echo("<a href=update.php?id=$qID>EDIT</a> <br>");
            }
        }
        
    ?>
</body>
</html>