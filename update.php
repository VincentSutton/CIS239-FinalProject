<?php
    include 'API'.DIRECTORY_SEPARATOR.'database.php';
    session_start();
    // Check if they're logged in
    if(!isset($_SESSION['username'])||!isset($_SESSION['userID'])){
        header("Location: login.php");
    }
    $postID = filter_input(INPUT_GET,'id');
    $quoteText = "";
    $quoteAuth = "";
    $editable = 0;
    $action = "Add";
    $IDtoTest = $_SESSION['userID'];
    if($postID){
        $query = "SELECT * FROM api WHERE API_ID = $postID";
        $results = getQuery($query)[0];
        $originalPoster = $results['User_ID'];
        $quoteText = $results['API_Text'];
        $quoteAuth = $results['API_Author'];
        $editable = $results['API_Editable'];
        $action = "Edit";
        // Stop unauthorized users from editing
        if(!$editable && $IDtoTest != $originalPoster){
            haeder("Location: editdata.php");
        }
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
    <h1><?php
        echo($action);
    ?></h1>
    <form action="savechanges.php" method="post">
        <?php
            echo("Quote Text: <input type=text name=quotetext value=\"$quoteText\"><br>");
            echo("Author(if not you): <input type=text name=quoteauthor><br>");
            echo("<input type=hidden name=quoteid value=$postID>");
            if(isset($originalPoster)){
                $editPermsGranted = ($_SESSION['userID'] == $originalPoster)?'checkbox':'hidden';
            }else{
                $editPermsGranted = "checkbox";
            }
            echo("<input type=$editPermsGranted name=editable value=$editable> ");
            if($editPermsGranted == "checkbox"){
                echo("Anyone may edit this<br>");
            }
        ?>
        <input type="submit" value="Save">
    </form>
</body>
</html>