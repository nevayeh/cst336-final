<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Recipeat </title>
        <link href="styles.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>function clearBox(elementID){document.getElementById(elementID).innerHTML = "";ingredients = [];}</script>
        
    </head>
    <body>
        <br/>
        <div id = 'mainblock'>
            <br/>
            <h2 align = 'center'>Recipeat</h2>
            <div id = 'line'></div>
            
            <br/>
            
            <select id = 'ddMenu'>
              <option value="Eggs">Eggs</option>
              <option value="Flour">Flour</option>
              <option value="Milk">Milk</option>
              <option value="Sugar">Sugar</option>
            </select>
            
            <button type="button" id = 'confirm' onclick = 'conf()'>Add</button>
            
            <div id = 'basket'>temporary text [basket div]</div>
            
            
            <button type="button" id = 'wipe' onclick = 'clearBox("basket")'>Clear</button>
            
            
        
            
            
            
        </div>
        
        
        
        <script>
            var ingredients = [];
            
            function conf() {
                if(!ingredients.includes($('#ddMenu').val()))
                    ingredients.push($('#ddMenu').val());
                display();
                
            }
            
            function display() {
                var out = '';
                for (var i = 0; i < ingredients.length; i++) {
                    out += ingredients[i];
                    out += '<br/>';
                }
                
                $("#basket").html(out);
                
                
            }
            
            
        </script>
        

    </body>
</html>