<?php

session_start();

include_once "database.php";

function getUserID()
{
    $dbConn = getDatabaseConnection();
    $name = $_SESSION['user'];
    $sql = "SELECT userid FROM `final_users` WHERE username=:user";
    $statement = $dbConn->prepare($sql);
    $statement->execute(array(":user" => $name));
    $records = $statement->fetchAll();
    return $records[0]['userid'];
}


function getUserRecipes()
{
    $userID = getUserID();
    $dbConn = getDatabaseConnection();
    $sql = "SELECT * 
            FROM final_user_recipes
            INNER JOIN final_users
            ON final_user_recipes.userid=final_users.userid
            WHERE final_user_recipes.userid=:user";
    $statement = $dbConn->prepare($sql);
    $statement->execute(array(":user" => $userID));
    $records = $statement->fetchAll();
    
    return $records;
}

function getUserActivity()
{
    $userID = getUserID();
    $dbConn = getDatabaseConnection();
    $sql = "SELECT  final_user_activities.activity, final_user_activities.recipename, final_user_activities.time
            FROM final_user_activities
            INNER JOIN final_users
            ON final_user_activities.userid=final_users.userid
            WHERE final_user_activities.userid=:user
            ORDER BY final_user_activities.time DESC";
    $statement = $dbConn->prepare($sql);
    $statement->execute(array(":user" => $userID));
    $records = $statement->fetchAll();
    
    return $records;
}

?>