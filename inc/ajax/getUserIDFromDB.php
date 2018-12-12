<?php

include_once '../../database.php';

// $dbConn = getDatabaseConnection(); 

echo json_encode(getUser($_GET['user']));

function getUser($username)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT userid FROM `final_users` WHERE username=:username"; //change 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':username' => $username)); //change

    $records = $statement->fetchAll(); 
    
    return $records;
}



?>