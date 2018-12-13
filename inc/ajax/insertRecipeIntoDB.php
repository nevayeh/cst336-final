<?php

include_once '../../database.php';

$dbConn = getDatabaseConnection(); 
    
$id = $_GET['id'];
$recipeId = $_GET['recipeId'];
$name = $_GET['name'];
$url = $_GET['img'];
$desc = $_GET['desc'];

echo json_encode(checkDupe($id, $recipeId, $name, $url, $desc));

function checkDupe($id, $recipeId, $name, $url, $desc)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * FROM `final_user_recipes` WHERE userid=:id AND recipeid=:recipeid";
    
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':id' => $id, ':recipeid' => $recipeId)); 

    $records = $statement->fetchAll(); 
    
    if(count($records) > 0)
        return "Duplicate";
    else
        insertRecipe($id, $recipeId, $name, $url, $desc);
    
}

function insertRecipe($id, $recipeId, $name, $url, $desc)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "INSERT INTO `final_user_recipes` (`entry`, `userid`, `recipeid`, `name`, `imageURL`, `description`) VALUES (NULL, :id, :recipeid, :name, :url, :desc)";

    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':id' => $id, ':recipeid' => $recipeId, ':name' => $name, ':url' => $url, ':desc' => $desc)); 
    

    $records = $statement->fetchAll(); 
    
    return "Success";
}
    
?>