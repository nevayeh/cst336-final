<?php
session_start(); 

include '../database.php'; 

$dbConn = getDatabaseConnection(); 


$username = $_GET['username'];
$password = $_GET['password'];

echo json_encode(validate($username, $password));

function validate($username, $password) {
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * FROM `users_final` WHERE username=:username AND password=:password"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':username' => $username, ':password' => $password));

    $records = $statement->fetchAll(); 
    
    
    if (count($records) >= 1) {
        // login successful
        // $_SESSION['user_id'] = $records[0]['user_id']; 
        // $_SESSION['username'] = $records[0]['username']; 
        // header('Location: home.php');
        //return json_encode(true); 
        return true; 
        
    }  else {
        //echo "<div class='error'>Username and password are invalid </div>";
        //return json_encode(false); 
        return false;
    }
}

// echo json_encode(array(
//         "userName" => $json["userName"], 
//         "found" => $found    
//     )); 

?>