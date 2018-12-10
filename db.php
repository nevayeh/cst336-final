<?php
include 'database.php';
$dbConn = getDatabaseConnection(); 
$name = $_POST['formGroupUsernameInput'];
$password = $_POST['formGroupPasswordInput'];
$sql = "INSERT into users (`username`, 	`password`) VALUES ('$name', '$password)"; 
$statement = $dbConn->prepare($sql); 
$statement->execute();

$records = $statement->fetchAll(); 


?>