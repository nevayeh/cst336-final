<?php

include_once '../../../database.php';

echo json_encode(editRecipe($_GET['user'], $_GET['recipe'], $_GET['newName'], $_GET['newDesc']));

function editRecipe($user, $recipe, $name, $desc)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "UPDATE `final_user_recipes`
            SET name=:newname, description=:newdesc
            WHERE userid=:user AND recipeid=:recipe";

    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':newname' => $name, ':newdesc' => $desc, ':user' => $user, ':recipe' => $recipe)); 

    return "Edited";

}
    
?>