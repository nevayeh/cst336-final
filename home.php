<?php

session_start();

include './api/spoonacularAPI.php';

if(isset($_SESSION['user']))
{
    $loggedIn = true;
}

if(isset($_GET['tag']))
{
    $tag= $_GET['tag'];
    // $number = $_GET['quantity'];
}

if(isset($_GET['quantity'])){
    $quantity = $_GET['quantity'];
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
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <?php if (!$loggedIn){?>
                        <a class="nav-item nav-link" id="logInButton" href="#" onclick="createLogInModal()">Log In</a>
                        <?php } else {?>
                        <a class="nav-item nav-link" id="logOutButton" href="#" onclick="logout()">Log Out</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
             <?php if ($loggedIn){?>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link" id="loggedInAs">Logged in as <?php echo $_SESSION['user'] ?> | </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                </ul>
            </div>
            <?php } ?>
        </nav>
        
        <br>
        
        <header>
            <h1>Recipe Search</h1>
        </header>
        
        <main>
            <form>
                <div class = 'inputs'>
                    <input class = 'inputs' type="text" name="tag" placeholder = "e.g. Milk, Chocolate" value="<?=$_GET['tag']?>"/>
                    <input type="number" name="quantity" min="1" max="5" placeholder="#" value="<?php echo isset($_GET['quantity']) ? $_GET['quantity'] : 5 ?>" />
                    <input class = 'inputs' type="image" src = './img/glass.png' id = 'searchButton'/>
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
                        $factOnly = $_SESSION['fact'];
                        echo substr($factOnly, 11);
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
                    if(!empty($tag))
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
                            
                            echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createRecipeModal(this.id)">';
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
            
        </main>
        
        <script src="js/functions.js"></script>
        <script src="modal/modal.js"></script>
        
    </body>    
</html>
