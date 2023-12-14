<?php
    include 'verify_login.php';

    header('Content-Type: application/json');

    $sql = "Select * from API";

    // Change the query to just return the authors if we have an author input
    $author = filter_input(INPUT_GET, 'author');
    $key = filter_input(INPUT_GET,'key');

    // Skip the query if our key is invalid
    if(validate_key($key)){
        $results = getQuery($sql);
    }else{
        $results = array();
        $results[] = array(
            'API_Text' => "Please check if your key is correct then try again",
            'API_Author' => "Invalid Key"
        );
    }

    // Sort our results into an array
    $output = array(
        'data' => array()
    );
    foreach($results as $quote){
        $output['data'][] = array(
            'quoteText' => $quote['API_Text'],
            'quoteAuthor' => $quote['API_Author']
        );
    }

    // Turn it into JSON
    echo json_encode($output);
?>