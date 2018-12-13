<?php

include_once '../../../database.php';

echo json_encode(checkDupe($_GET['id'], $_GET['recipeId'], $_GET['name'], $_GET['img'], $_GET['desc']));

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