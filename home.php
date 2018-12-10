<?php
include './api/spoonacularAPI.php';
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
            THIS IS STYLE SHEET FOR BOOTSTRAP 3
            THE MODAL USES BOOTSTRAP 4, but won't work with 3 still enabled
            So I'll leave this here in case we need it for something
             
            <link href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel = "stylesheet">
        -->
        
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
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                
              <a class="nav-item nav-link" id="logIn" href="#" onclick="createLogInModal()">Log-In</a> <!--when clicked calls the createLogInModal() function-->
              
              <!--<a class="nav-item nav-link" href="#">TEXT GOES HERE</a>-->
              <!--<a class="nav-item nav-link" href="#">TEXT GOES HERE</a>-->
            </div>
          </div>
        </nav>
        
        <br>
        
        <header>
            <h1>Recipe Search</h1>
        </header>
        
        <main>
            <form>
                <div class = 'inputs'>
                    <input class = 'inputs' type="text" name="tag" placeholder = "e.g. Milk, Chocolate" value="<?=$_GET['tag']?>"/>
                    <input type="number" name="quantity" min="1" max="5" placeholder=# />
                    <input class = 'inputs' type="image" src = './img/glass.png' id = 'searchButton'/>
                </div>
                
            </form>
            
            
            <!--FOOD FACT DIV-->
            <div id="fact">
                <!--Food Fact!-->
                Did you know?
                <div id = 'factText'>
                <?php 
                    $foodFact = foodFact();
                    echo $foodFact['text'];
                ?>
                </div>
            </div>
            
            
            <!--FOOD JOKE DIV
            <div id="joke">
                The Lols
                <br/>
                <?php 
                    $joke = foodJoke();
                    echo $joke['text'];
                ?>
            </div>
            -->
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
                        echo "<h2 style= 'margin: 0'> Results for ". $_GET['tag']. "</h2>";
                        $recipes = ingredientSearch($_GET['tag'], $quantity);
                        echo "<br>";
                        //print_r($recipes);
                        
                        for($i = 0; $i < $quantity; $i++)
                        {
                            
                            /*
                            
                            //---------------------------------------------------------------------------------------
                            // ! ! ! Do not use this if code block below is used ! ! !
                            //
                            // Recipe title and image goes in a "recipeResult" div
                            // User can click anywhere on div (includes empty space on either side of image / title)
                            // ---------------------------------------------------------------------------------------
                            
                            echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createRecipeModal(this.id)">';
                            echo "<p style='color:white'>" . $recipes[$i]['title'] . "</p>";
                            // echo getInstructions($recipes[$i]['id'])['instructions']; //recipe instructions
                            // $description = descriptionSearch($recipes[$i]['id']);
                            // echo descriptionSearch($recipes[$i]['id'])['summary'];
                            // echo $description['summary'];
                            echo "<br>";
        
                            echo "<img src='" . $recipes[$i]['image'] ."'>";
                            echo '</div>';
                            echo '<br/><br/>';
                            
                            */
    
                            // ---------------------------------------------------------------------------------------
                            // ! ! ! Do not use this if code block above is used ! ! !
                            //
                            // Recipe and title will both create the modal for the respective recipe
                            // User cannot click on empty space to side of image/title
                            // ---------------------------------------------------------------------------------------
                            //print_r($recipes);
                            
                            echo '<div class="recipeResult">';
                            echo '<label id="' . $recipes[$i]['id'] . '" style="color:white;font-size:30px;padding:10px 50px;margin-bottom:0px" onclick="createRecipeModal(this.id)">' . $recipes[$i]['title'] . '</label><br/>';
                            echo '<img id="' . $recipes[$i]['id'] . '" src="' . $recipes[$i]['image'] .'" onclick="createRecipeModal(this.id)">';
                            echo '</div>';
                            echo '<br/>';
                            
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
                            <!--<div class="modal-footer">-->
                                <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div> <br/>
                

            
        </main>
        
        <script src="modal/modal.js"></script>
        <script src="js/functions.js"></script>
        <script type="text/javascript">
            $("#cookTime").on("click", function(){
               if($(this).is(":checked")){
                   console.log("CHECKED");
                   $("#base").html("");
               }
            });
            
        </script>

    </body>    
</html>