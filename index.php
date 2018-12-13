<?php

session_start();

include_once './api/spoonacularAPI.php';

if(isset($_SESSION['user']))
{
    $loggedIn = true;
    $loggedUser = $_SESSION['user'];
}
else
{
    $loggedIn = false;    
}

if(isset($_GET['tag']))
{
    $tag= $_GET['tag'];
    // $number = $_GET['quantity'];
}

if(isset($_GET['quantity']))
{
    $quantity = $_GET['quantity'];
}
if(isset($_GET['cookTime']))
{
    $cookTime = $_GET['cookTime'];
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
    
    <body>
        
        <?php include_once "inc/navigation.php" ?>
        
        <header>
            <h1>Recipe Search</h1>
        </header>
        
        <main>
            <form>
                <div class = 'inputs'>
                    <input class = 'inputs' type="text" name="tag" placeholder = "e.g. Milk, Chocolate" value="<?=$_GET['tag']?>"/>
                    <input type="number" name="quantity" min="1" max="5" placeholder="#" value="<?php echo isset($_GET['quantity']) ? $_GET['quantity'] : 5 ?>" />
                    <input class = 'inputs' type="image" src = './img/glass.png' id = 'searchButton'/><br>
                    Ready in 30 min or Less<br><input type="checkbox" id="cookTime" name="cookTime" value="30">
                </div>
                
            </form>
            
            
            <!--FOOD FACT DIV-->
            <div id="fact">
                Did you know?
                <div id = 'factText'>
                <?php 
                    //Keeps fact the same after refreshing page (refreshing navbar change after logging in or out)
                    if(isset($_SESSION['fact']))
                    {
                        // $factOnly = $_SESSION['fact'];
                        // echo substr($factOnly, 11);
                        echo $_SESSION['fact'];
                        unset($_SESSION['fact']);
                    }
                    else
                    {
                        $foodFact = foodFact();
                        echo $foodFact['text'];
                    }
                ?>
                </div>
            </div>
            
            <br>
    
            <div id = 'base' <?php if ($tag){?>style="display:block"<?php } ?>>
                <?php
    
                if(empty($_GET)) // form was not submitted
                { 
                    echo "";
                } 
                else // form was submitted
                { 
                    //print_r($quantity);
                    if(!empty($tag) && !isset($_GET['cookTime']))
                    {
                        if($_GET['quantity'] == "")
                            $quantity = 5;
                        
                        echo "<h2 style= 'margin: 0'> Results for ". $_GET['tag']. "</h2>";
                        $recipes = ingredientSearch($_GET['tag'], $quantity);
                        echo "<br>";
                        //print_r($recipes);
                        
                        for($i = 0; $i < $quantity; $i++)
                        {
                            
                            
                            //---------------------------------------------------------------------------------------
                            // ! ! ! Do not use this if code block below is used ! ! !
                            //
                            // Recipe title and image goes in a "recipeResult" div
                            // User can click anywhere on div (includes empty space on either side of image / title)
                            // ---------------------------------------------------------------------------------------
                            
                            echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createRecipeModal(this.id, ' . $loggedIn . ')">';
                            echo "<p style='color:white;margin-bottom: 20px'>" . $recipes[$i]['title'] . "</p>";
                            echo "<img style='width:500px;height:344px' src='" . $recipes[$i]['image'] ."'>";
                            echo '</div>';
                            echo '<br/><br/>';
                            
                            
                            /*
                            // ---------------------------------------------------------------------------------------
                            // ! ! ! Do not use this if code block above is used ! ! !
                            //                            
                            // Recipe and title will both create the modal for the respective recipe
                            // User cannot click on empty space to side of image/title
                            // ---------------------------------------------------------------------------------------
                            
                            echo '<div class="recipeResult">';
                            echo '<label id="' . $recipes[$i]['id'] . '" style="color:white;font-size:30px;padding:10px 50px;margin-bottom:0px" onclick="createRecipeModal(this.id)">' . $recipes[$i]['title'] . '</label><br/>';
                            echo '<img class="resultImage" id="' . $recipes[$i]['id'] . '" style="width:500px;height:344px" src="' . $recipes[$i]['image'] .'" onclick="createRecipeModal(this.id)">';
                            echo '</div>';
                            echo '<br/>';
                            */
                            
                        }
                    }
                    
                    if(!empty($tag) && isset($_GET['cookTime']))
                    {
                        if($_GET['quantity'] == "")
                            $quantity = 5;
                        
                        echo "<h2 style= 'margin: 0'> Results for ". $_GET['tag']. "</h2>";
                        $recipes = ingredientSearch($_GET['tag'], $quantity);
                        echo "<br>";
                        
                        for($i = 0; $i < $quantity; $i++)
                        {
                            $temp = getInstructions($recipes[$i]['id'])['readyInMinutes'];
                            
                            if($temp <= $_GET['cookTime'])
                            {
                                echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createRecipeModal(this.id, ' . $loggedIn . ')">';
                                echo "<p style='color:white;margin-bottom: 20px'>" . $recipes[$i]['title'] . "</p>";
                                echo "<img style='width:500px;height:344px' src='" . $recipes[$i]['image'] ."'>";
                                echo '</div>';
                                echo '<br/><br/>';
                            }
                        }
                        
                    }
                }
                
                ?>
            </div>
                
                <!--RECIPE MODAL-->
                <div class="modal fade" id="recipeModal" tabindex="-1" role="dialog" aria-labelledby="recipeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="recipeModalLabel"></h5> <!-- RECIPE NAME GOES IN HERE -->
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="inline-block" id="recipeImgDiv"></div> <!-- RECIPE IMAGE GOES HERE -->
                                <div style="inline-block" id="recipeInfoDiv" ></div> <!-- RECIPE INFO GOES HERE -->
                            </div>
                            <div class="modal-footer">
                                <?php 
                                    if($loggedIn)
                                    {
                                        echo '<button type="button" class="btn btn-primary" id="saveRecipeButton">Save Recipe</button>';
                                        echo '<button type="button" class="btn btn-success" id="recipeSavedMessageButton" onclick="this.blur()">Recipe saved!</button>';
                                        echo '<button type="button" class="btn btn-warning" id="alreadySavedMessageButton" onclick="this.blur()">Recipe already saved!</button>';
                                    }
                                    else
                                    {
                                        echo '<button type="button" class="btn btn-secondary" id="logInMessageButton" onclick="this.blur()">Log in to save recipe</button>';
                                    }
                                ?>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="doneButton">Done</button>
                            </div>
                        </div>
                    </div>
                </div> <br/>
                
                <!--LOG IN MODAL-->
                <div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logInModalLabel">Log In</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--Username-->
                                <div class="form-group">
                                    <label for="formGroupUsernameInput">Username</label>
                                    <input type="text" class="form-control" id="formGroupUsernameInput" placeholder="Username">
                                </div>
                                <!--Password-->
                                <div class="form-group">
                                    <label for="formGroupPasswordInput">Password</label>
                                    <input type="password" class="form-control" id="formGroupPasswordInput" placeholder="Password">
                                </div>
                                <div id="logInVerification"></div> <!-- LOG IN ERROR MESSAGE GOES HERE (if wrong credentials) -->
                                <button type="button" class="btn btn-success" style="padding:10px 50px" id="signInButton">Sign In</button>
                            </div>
                        </div>
                    </div>
                </div> <br/>
                
                <?php echo "<input type='hidden' id='hiddenUsername' value='" . $_SESSION['user'] . "'>" ?>
                
        </main>
        
        <script src="inc/js/functions.js"></script>
        <script src="inc/js/modal.js"></script>
        
    </body>    
</html>
