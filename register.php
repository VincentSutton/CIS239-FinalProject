<?php
    include "API".DIRECTORY_SEPARATOR."database.php";
    // Specify how long a key should be
    $newKeyLength = 8;

    $email = filter_input(INPUT_GET,'email');
    $username = filter_input(INPUT_GET,'user');
    $password = filter_input(INPUT_GET,'pass');
    // Check if the user has everything implemented
    $errorMsg = "";
    $errorMsg .= $username?"":" Please enter a username.";
    $errorMsg .= $password?"":" Please enter a password.";
    $errorMsg .= $email?"":" Please enter an E-Mail address.";
    // Check if the email is already in the database
    $query = "SELECT * FROM users";
    foreach(getQuery($query) as $user){
        if($user['User_EMail']==$email){
            $errorMsg = "E-Mail Already in use.";
        }
    }
    if(!$errorMsg){
        // Make a key for the new user
        $apiKey = bin2hex(random_bytes($newKeyLength));
        // Hash their password
        $password = password_hash($password,PASSWORD_DEFAULT);
        // Add the new user and key to the database
        $query = "INSERT INTO `users`(`User_EMail`, `User_Key`, `User_Name`, `User_Pass`) VALUES (\"$email\",\"$apiKey\",\"$username\",\"$password\")";
        getQuery($query);

        header("Location: editdata.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <?php
        if($email||$password||$username){
            echo($errorMsg);
        }
    ?>
    <form action="register.php">
        Username: <input type="text" name="user"><br>
        Password: <input type="password" name="pass"><br>
        E-Mail: <input type="text" name="email"><br>
        <input type="submit" value="Generate Key">
    </form>
</body>
</html>