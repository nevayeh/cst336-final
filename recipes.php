<?php

session_start();

include_once './api/spoonacularAPI.php';

if(isset($_SESSION['user']))
{
    $loggedIn = true;
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
        <style>@import url("./css/styles.css");</style>
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>   

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
    
    <body>
        
        <?php include_once "inc/navigation.php" ?>
        
        <!--<header>-->
            
        <!--</header>-->
        
        <main>
            
            <h3>This page is a work in progress</h3>
            <button onclick="createEditRecipeModal(977701)">TEST</button>


            <!--RECIPE MODAL-->
            <div class="modal fade" id="editRecipeModal" tabindex="-1" role="dialog" aria-labelledby="editRecipeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRecipeModalLabel"></h5> <!-- RECIPE NAME TO EDIT GOES IN HERE -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="inline-block" id="editRecipeImgDiv"></div> <!-- RECIPE IMAGE TO EDIT GOES HERE -->
                            <div style="inline-block" id="editRecipeInfoDiv" ></div> <!-- RECIPE INFO TO EDIT GOES HERE -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="deleteRecipeButton">Delete Recipe</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveChangesButton">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeButton">Close</button>
                        </div>
                    </div>
                </div>
            </div> <br/>
            
            
        </main>
        
        <script src="inc/js/functions.js"></script>
        <script src="inc/js/modal.js"></script>
        
    </body>    
</html>
