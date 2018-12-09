<?php
require 'vendor/autoload.php';
function ingredientSearch($ing, $num)
{
  $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByIngredients?number=6&ranking=1&ingredients=$ing",  
  array(
    "X-Mashape-Key" => "2048cb4ac9msh7d61493d3c856fcp1e39fejsn199dba1c9292",
    "Accept" => "application/json"
  )
);
    $data= json_decode($response -> raw_body,true );
    return $data;

}
function descriptionSearch($foodID){
  $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/$foodID/summary",  
  array(
    "X-Mashape-Key" => "2048cb4ac9msh7d61493d3c856fcp1e39fejsn199dba1c9292",
    "Accept" => "application/json"
  )
);
    $data= json_decode($response -> raw_body,true );
    return $data;

}

function foodFact(){
  $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/food/trivia/random",  
  array(
    "X-Mashape-Key" => "2048cb4ac9msh7d61493d3c856fcp1e39fejsn199dba1c9292",
    "Accept" => "application/json"
  )
);
    $data= json_decode($response -> raw_body,true );
    return $data;

}

?>