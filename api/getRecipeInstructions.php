<?php

require 'vendor/autoload.php';

echo json_encode(getInstructions($_GET['id']));

function getInstructions($foodID)
{
    $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/$foodID/information",  
        array(
            "X-Mashape-Key" => "2048cb4ac9msh7d61493d3c856fcp1e39fejsn199dba1c9292",
            "Accept" => "application/json"
        )
    );
    
    $data= json_decode($response -> raw_body,true );
    return $data;
}

?>