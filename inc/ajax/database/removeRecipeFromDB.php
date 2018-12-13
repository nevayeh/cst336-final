<?php

include_once '../../../database.php'; 

echo json_encode(removeRecipe($_GET['id'], $_GET['recipeId']));

function removeRecipe($userid, $recipeid)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "DELETE FROM `final_user_recipes` WHERE userid=:id AND recipeid=:recipeid"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':id' => $userid, ':recipeid' => $recipeid)); 

    return "Removed";
}

?>