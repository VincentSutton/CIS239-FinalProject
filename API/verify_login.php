<?php
    include 'database.php';

    // Check if they have a valid key
    function validate_key($testKey){
        $query = "SELECT User_Key FROM users";
        $results = getQuery($query);
        $output = false;
        foreach($results as $keyToMatch){
            if($keyToMatch['User_Key'] == $testKey){
                $output = true;
            }
        }
        return $output;
    }

    // Get the user's ID upon login
    function verify_login($username, $password){
        $query = "SELECT * FROM users";
        $results = getQuery($query);
        $output = false;
        // Find a valid username then check their password
        foreach($results as $userInfo){
            if($username == $userInfo['User_Name']){
                if(password_verify($password, $userInfo['User_Pass'])){
                    // Get their user ID when successful
                    $output = $userInfo['User_ID'];
                }
            }
        }
        return $output;
    }

?>