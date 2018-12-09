<?php
include './api/spoonacularAPI.php';
if(isset($_GET['tag']))
{
    $tag= $_GET['tag'];
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

    </head>
    
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                
              <a class="nav-item nav-link" id="logIn" href="#" onclick="logInModal()">Log-In</a>
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
            <input type="text" name="tag" placeholder = "Enter Ingredients" value="<?=$_GET['tag']?>"/>
            </br>

            <!--<input type="Submit" value="Search"/>-->
            <!--<button id="trivia">test</button>-->

            <input type="image" src = './img/glass.png' id = 'searchButton'/>

        </form>
        
        <!--FOOD FACT DIV-->
        <div id="fact">
            Food Fact!
            <br>
            <?php
                $foodFact = foodFact();
                echo $foodFact['text'];
            ?>
        </div>
        
        <br>
        
        <button type="button" class="recipeModalButton" data-toggle="modal" data-target="#recipeModal" onclick="createTestModal()">
            Test Recipe Modal
        </button>
        
        <?php
        
        //RECIPE MODAL
        echo '<div class="modal fade" id="recipeModal" tabindex="-1" role="dialog" aria-labelledby="recipeModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog modal-lg" role="document">';
                echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="recipeModalLabel"></h5>'; //RECIPE NAME GOES IN HERE
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                        echo '<div style="inline-block" id="recipeImgDiv"></div>'; //RECIPE IMAGE GOES HERE
                        echo '<div style="inline-block" id="recipeInfoDiv" ></div>'; //RECIPE INFO GOES HERE
                    echo '</div>';
                    echo '<div class="modal-footer">';
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div> <br/>';
        
        //LOG IN MODAL
        echo '<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog modal-lg" role="document">';
                echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="logInModalLabel">Log In</h5>'; 
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                        //Username
                        echo '<div class="form-group">';
                            echo '<label for="formGroupUsernameInput">Username</label>';
                            echo '<input type="text" class="form-control" id="formGroupUsernameInput" placeholder="Username">';
                        echo '</div>';
                        //Password
                        echo '<div class="form-group">';
                            echo '<label for="formGroupPasswordInput">Password</label>';
                            echo '<input type="password" class="form-control" id="formGroupPasswordInput" placeholder="Password">';
                        echo '</div>';
                        echo '<div id="logInVerification"></div>'; //LOG IN ERROR MESSAGE GOES HERE (if wrong credentials)
                        echo '<button type="button" class="btn btn-success" style="padding:10px 50px" id="signInButton">Sign In</button>';
                    echo '</div>';
                    // echo '<div class="modal-footer">';
                        // echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    // echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div> <br/>';
        
        
        if(empty($_GET)) // form was not submitted
        { 
            echo "";
        } 
        else // form was submitted
        { 
            if(!empty($tag))
            {
                echo "<h2 style= 'margin: 0'> You searched for: ". $_GET['tag']. "</h2>";
                $recipes = ingredientSearch($_GET['tag'], 5);

                echo "<br>";
                //print_r($recipes);
                
                for($i = 0; $i < 5; $i++)
                {
                    /*
                    
                    // ---------------------------------------------------------------------------------------
                    // Recipe title and image goes in a "recipeResult" div
                    // User can click anywhere on div (includes empty space on either side of image / title)
                    // ---------------------------------------------------------------------------------------
                    
                    echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createModal(this.id)">';
                    echo "<p style='color:white' id='recipeLabel" . $i . "'>" . $recipes[$i]['title'] . "</p>";
                    echo "<img src='" . $recipes[$i]['image'] ."'>";
                    echo '</div>';
                    echo '<br/><br/>';
                    */
                    
                    // ---------------------------------------------------------------------------------------
                    // Recipe and title will both create the modal for the respective recipe
                    // User cannot click on empty space to side of image/title
                    // ---------------------------------------------------------------------------------------
                    
                    echo '<div class="recipeResult">';
                    echo '<label id="' . $recipes[$i]['id'] . '" style="color:white;font-size:40px;padding:10px 50px;margin-bottom:0px" onclick="createModal(this.id)">' . $recipes[$i]['title'] . '</label><br/>';
                    echo '<img id="' . $recipes[$i]['id'] . '" src="' . $recipes[$i]['image'] .'" onclick="createModal(this.id)">';
                    echo '</div>';
                    echo '<br/>';
                }
            }
        }
        ?>
        </main>
        
        <script src="modal/modal.js"></script>
        <script src="js/functions.js"></script>

    </body>    
</html>