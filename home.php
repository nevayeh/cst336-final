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
    </head>
    <body>
        <?php include 'navigation.php' ?>
        <br><br><br>
        <header>
            <h1>Recipe Search</h1>
        </header>
        
        
        <main>
        <form>
            <input type="text" name="tag" placeholder = "Enter Ingredients" value="<?=$_GET['tag']?>"/>
            </br>
            <input type="Submit" value="Search"/><button id="trivia">test</button>
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
                echo "<h1 style= 'margin: 0'> You searched for: ". $_GET['tag']. "</h1>";
                $recipes = ingredientSearch($_GET['tag'], 5);
                //print_r($recipes);
                echo "<br>";
                for($i = 0; $i < 5; $i++)
                {
                    echo $recipes[$i]['title'];
                    echo "<br>";
                    echo "<img src= " . $recipes[$i]['image'] .">";
                    echo "<br></br>";
                }
            }
        }
        ?>
        
        <div class="container">
  <!--<h2>Modal Example</h2>-->
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Recipe</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ingredients</h4>
        </div>
        <div class="modal-body">
          <p>• Bread</p>
          <p>• Milk</p>
          <p>• Eggs</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
        </main>
        <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


</body>
</html>

    </body>    
</html>