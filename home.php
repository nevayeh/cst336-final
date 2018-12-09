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
                
              <a class="nav-item nav-link" id="logIn" href="#" onclick="logIn()">Log-In</a>
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
                        echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    echo '</div>';
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
                    // $recipeImage = $recipes[$i]['image'];
                    echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createModal(this.id)">';
                    // echo '<div class="recipeResult" id="' . $recipes[$i]['id'] . '" onclick="createModal(this.id, ' . $recipeImage . ')">';
                    echo "<p style='color:white'>" . $recipes[$i]['title'] . "</p>";
                    //$description = descriptionSearch($recipes[$i]['id']);
                    // echo descriptionSearch($recipes[$i]['id'])['summary'];
                    // echo $description['summary'];
                    // echo "<br>";
                    echo "<img src='" . $recipes[$i]['image'] ."'>";
                    // echo "<br></br>";
                    echo '</div>';
                    echo '<br/><br/>';
                    // echo '</button>';
                }
            }
        }
        ?>
        </main>
        
        <script src="modal/modal.js"></script>
        <script src="js/functions.js"></script>

    </body>    
</html>