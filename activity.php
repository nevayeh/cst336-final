<?php
session_start();

include_once "inc/functions.php";

if(isset($_SESSION['user']))
{
    $loggedIn = true;
    $name = $_SESSION['user'];
}
else
{
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recipe Finder</title>
        <!--
            !!!!!! IMPORTANT !!!!!
            PLEASE DON'T CHANGE THE ORDER OF THESE STYLE AND SCRIPT TAGS
        -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="icon" href="img/chefhat.png">
        <style>@import url("./css/styles.css");</style>
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>   
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
    
    <body style="padding-bottom: 50px">
        
        <?php include_once "inc/navigation.php"; ?>
        
        <main>

            <h1>Your Activity</h1>

            <?php $records = getUserActivity(); ?>
        
            <table class="table table-striped" style="width:75%;margin:auto;background-color:#F5F5F5;border-radius:25px">
                <thead>
                    <tr>
                        <th scope="col" style="width: 150px">Action</th>
                        <th scope="col">Recipe</th>
                        <th scope="col" style="width: 150px">Time</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php
                
                    foreach($records as $activity)
                    {
                        echo '<tr>';
                            echo '<td>' . $activity['activity'] . '</td>';
                            echo '<td>' . $activity['recipename'] . '</td>';
                            echo '<td>' . $activity['time'] . '</td>';
                        echo '</tr>';
                    }
                
                ?>
            
            </tbody>
        </table>

        </main>
        
        <script src="inc/js/functions.js"></script>
        <script src="inc/js/modal.js"></script>
        
    </body>    
</html>
