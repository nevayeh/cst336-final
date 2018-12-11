<?php
// session_start(); 

include '../../database.php'; 

$dbConn = getDatabaseConnection(); 

echo json_encode("hi");

// $username = $_GET['username'];
// $password = $_GET['password'];

// echo json_encode(array("username" => $username, "found" => validate($username, $password)));

function validate($username, $password) {
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * FROM `users_final` WHERE username=:username AND password=:password"; //change 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':username' => $username, ':password' => $password)); //change

    $records = $statement->fetchAll(); 
    
    
    // if (count($records) >= 1)
    // {
    //     return "true";
        
    // }
    // else
    // {
    //     return "false";
    // }
}

?>