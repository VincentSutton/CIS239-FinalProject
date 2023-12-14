<?php
    include 'API'.DIRECTORY_SEPARATOR.'database.php';

    session_start();
    $IDtoTest = $_SESSION['userID'];
    try{
        $editable = filter_input(INPUT_POST,'editable')?1:0;
        $quoteText = filter_input(INPUT_POST,'quotetext');
        $quoteAuthor = filter_input(INPUT_POST,'quoteauthor')?filter_input(INPUT_POST,'quoteauthor'):$_SESSION['username'];
        $quoteID = filter_input(INPUT_POST,'quoteid');
        if(is_numeric($quoteID)){
            $query = "UPDATE `api` SET `API_Text`='$quoteText',`API_Author`='$quoteAuthor',`API_Editable`= $editable WHERE `API_ID` = $quoteID; ";
        }else{
            $query = "INSERT INTO `api`( `User_ID`, `API_Text`, `API_Author`, `API_Editable`) VALUES ($IDtoTest,'$quoteText','$quoteAuthor',$editable); ";
        }
        getQuery($query);
        header("Location: editdata.php");
    }catch(PDOException $e){
        header("Location: update.php");
    }
?>