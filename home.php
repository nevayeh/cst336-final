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
       
        <style>
            @import url("./css/styles.css");
        </style>
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet">
    </head>
    <header>
        <h1>Recipe Search</h1>
    </header>
    <body>
        <main>
        <form>
            <input type="text" name="tag" placeholder = "Keyword" value="<?=$_GET['tag']?>"/>
            </br>
            <input type="Submit" value="Search"/>
        </form>
        
        
        
        
        
        <?php
        if(empty($_GET)) { // form was not submitted
            echo"Type a keyword to search for a recipe. <br/> <h2> Seperate multiple ingredients by commas, no spaces.</h2>";
        } 
        else 
        { // form was submitted
            if(empty($tag))
            {
                echo "<h1>Please enter a search term</h1>";
            }
            else
            {
                echo "<h1 style= 'margin: 0'> You searched for: ". $_GET['tag']. "</h1>";
                $recipes = ingredientSearch($_GET['tag'], 5);
                //print_r($recipes);
                
                echo "<br>";
                for($i = 0; $i < 5; $i++){
                    echo $recipes[$i]['title'];
                    echo "<br>";
                    echo "<img src= " . $recipes[$i]['image'] .">";
                    echo "<br></br>";
                }
                
                //     for ($k = 0; $k < 5; $k++) 
                //     {
                //     echo "<img src= '" . $recipe['recipes'][$k]['image'] ."' alt= '".$recipe['recipes'][$k]['title']."'><br/>";
           
                //     print_r($recipe['recipes'][$k]);
                //     echo "<br/>";
                //     $i=1;
                //     echo "<div class= 'recipeInfo'>";
                //     // foreach ($recipe['recipes'][$k] as $ingredient) 
                //     // {
                //     //     echo "$i. " . $ingredient['originalString']."<br/>";
                //     //     $i++;
                //     // }
                //     print_r($recipe['recipes'][$k]);
                //         echo "</div>";
                //         if(!empty($nutrition))
                //             visualizeData($recipe['recipes'][$k]['id']);
                //     }
                
                
            }
                
                
                
        }
        ?>
        </main>
        
    </body>    
</html>