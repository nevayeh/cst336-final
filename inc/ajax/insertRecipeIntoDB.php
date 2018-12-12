<?php

include_once '../../database.php';

$dbConn = getDatabaseConnection(); 
    
$id = $_GET['id'];
$name = $_GET['name'];
$url = $_GET['img'];
$desc = $_GET['desc'];

echo json_encode(insertRecipe($id, $name, $url, $desc));

function insertRecipe($id, $name, $url, $desc)
{
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "INSERT INTO `final_user_recipes` (`entry`, `userid`, `name`, `imageURL`, `description`) VALUES (NULL, :id, :name, :url, :desc)";

    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':id' => $id, ':name' => $name, ':url' => $url, ':desc' => $desc)); 
    

    $records = $statement->fetchAll(); 

    return array($id, $name, $url, $desc);
    
}

    
?>