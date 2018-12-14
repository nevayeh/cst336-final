<?php

include '../../database.php'; 

$username = $_GET['username'];
$password = $_GET['password'];

echo json_encode(array("username" => $username, "found" => validate($username, $password)));

function validate($username, $password) {
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * FROM `final_users` WHERE username=:username AND password=SHA1(:password)"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':username' => $username, ':password' => $password));

    $records = $statement->fetchAll(); 
    
    
    if (count($records) >= 1)
    {
        return "true";
        
    }
    else
    {
        return "false";
    }
}

?>