<?php

include_once '../../../database.php';

echo json_encode(logActivity($_GET['id'], $_GET['act'], $_GET['recipe']));

function logActivity($id, $activity, $recipename)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "INSERT INTO `final_user_activities` (`entry`, `userid`, `activity`, `recipename`, `time`) VALUES (NULL, :id, :act, :name, NOW())";

    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':id' => $id, ':act' => $activity, ':name' => $recipename)); 

    return "Logged: " . $activity;
}
    
?>