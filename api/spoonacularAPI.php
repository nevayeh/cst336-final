<?php
require 'vendor/autoload.php';
function randomRecipe($tag, $num) {
    //https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/random
    
    
    $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/random?limitLicense=false&number=$num&tags=$tag",
  array(
    "X-Mashape-Key" => "fQjFrq2zH9msheBNIkFYTnYSOjWFp11QH7Fjsnlgni7fj9dBtD",
    "Accept" => "application/json"
  )
  
);
    $data= json_decode($response -> raw_body,true );
    return $data;//json_decode($response,true); 
}

function ingredientSearch($ing, $num)
{
  $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByIngredients?number=6&ranking=1&ingredients=$ing",  
  //$response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/findByIngredients?fillIngredients=false&ingredients=$ing&limitLicense=false&number=$num&ranking=1",
  array(
    "X-Mashape-Key" => "2048cb4ac9msh7d61493d3c856fcp1e39fejsn199dba1c9292",
    "Accept" => "application/json"
  )
);
    $data= json_decode($response -> raw_body,true );
    return $data;//json_decode($response,true); 

}

function visualizeData($id)
{
   
    echo "</br>";
    $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/$id/nutritionWidget?defaultCss=true",
  array(
    "X-Mashape-Key" => "fQjFrq2zH9msheBNIkFYTnYSOjWFp11QH7Fjsnlgni7fj9dBtD",
    "Accept" => "text/plain"
  )
);
echo "This is supposed to show a really nice nutrient visualization but the API isn't working. Sorry!</br>";
echo $response->raw_body;
echo "</br>";
return $response;

}
?>