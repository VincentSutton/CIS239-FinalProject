<?php
    include 'API'.DIRECTORY_SEPARATOR.'verify_login.php';
    // Create a session on succesful login.
    session_start();
    $username = filter_input(INPUT_POST,'username');
    $password = filter_input(INPUT_POST,'password');

    $errorMsg = "";
    if(verify_login($username,$password)){
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = verify_login($username,$password);
        header("Location: editdata.php");
    }else{
        $errorMsg = ($username&&$password)?"The username and/or password are incorrect":"";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Please Log In</title>
</head>
<body>
    <?php
        echo($errorMsg);
    ?>
    <form action="login.php" method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Log In">
    </form>
    <a href="index.php">Go Back</a>
</body>
</html>