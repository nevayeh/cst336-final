<?php

include_once '../../../database.php'; 

echo json_encode(getRecipe($_GET['userid'], $_GET['recipeid']));

function getRecipe($userid, $recipeid)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * FROM `final_user_recipes` WHERE userid=:id AND recipeid=:recipeid"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':id' => $userid, ':recipeid' => $recipeid)); 

    $records = $statement->fetchAll(); 
    return $records;
}

?>