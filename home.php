<?php
if(isset($_GET['tag']))
{
    $tag= $_GET['tag'];
    include './api/spoonacularAPI.php';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Recipe Finder</title>
        <link href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel = "stylesheet">
        <style>@import url("./css/styles.css");</style>
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">


    </head>
    <body>
        <br>
        <header>
            <h1>Recipe Search</h1>
        </header>
        <main>
        <form>
            <input type="text" name="tag" placeholder = "Enter Ingredients" value="<?=$_GET['tag']?>"/>
            </br>
            <input type="image" src = './img/glass.png' id = 'searchButton'/>
        </form>
        
        <?php
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
                    echo "<p style='color:white'>" . $recipes[$i]['title'] . "</p>";
                    //$description = descriptionSearch($recipes[$i]['id']);
                    echo descriptionSearch($recipes[$i]['id'])['summary'];
                    echo $description['summary'];
                    echo "<br>";
                    echo "<img src= " . $recipes[$i]['image'] .">";
                    echo "<br></br>";
                }
            }
        }
        ?>
        </main>
        <script>
            
        </script>
    </body>    
</html>