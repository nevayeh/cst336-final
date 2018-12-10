function createLogInModal()
{
    // console.log("Somehow Create a Log In Modal Here");
    console.log("Showing log in modal");
    
    $("#logInModal").modal('show'); 
}
    
    
    

function createRecipeModal(id)
{
    console.log("creating modal. id: " + id);
    
    $("#recipeModal").modal('show');
    $("#recipeModalLabel").html(""); //prevents both loading and recipe info showing (after clicking on another recipe)
    $("#recipeImgDiv").html('<img style="width: 100px; height: 100px" src="img/loading-circle.gif" alt="loading"/>');
    $("#recipeInfoDiv").html("");
    
    $.ajax(
    {
        type: "get",
        url: "api/getRecipeInstructions.php",
        dataType: "json",
        data: {"id": id} ,
        success: function(data, status)
        {
            // console.log("SUCCESS INSTRUCTIONS");
            // console.log(data);
            
            var recipeInformation =
            {
                cookingMinutes: data.cookingMinutes,
                image: data.image,
                instructions: data.instructions,
                preparationMinutes: data.preparationMinutes,
                readyInMinutes: data.readyInMinutes,
                servings: data.servings,
                title: data.title,
                vegan: data.vegan,
                vegetarian: data.vegetarian
            }
            
            getRecipeDescription(id, recipeInformation);
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            alert("error instructions");   
            console.log("ERROR instructions");
            console.log(data);
        }
    });
}

function getRecipeDescription(id, recipe)
{
    $.ajax(
    {
        type: "get",
        url: "api/getRecipeInfo.php",
        dataType: "json",
        data: {"id": id} ,
        success: function(data, status)
        {
            // console.log("SUCCESS");
            // console.log(data);

            //Sets modal title to recipe name
            $("#recipeModalLabel").html(recipe.title);
            
            //Sets (or clears) the image in the modal
            //Use one or the other: 
            // $("#recipeImgDiv").html(""); //clears loading.gif
            $("#recipeImgDiv").html("<img style='width:400px;height:250px' src='" + recipe.image + "' alt='" + recipe.title + "'/>");
            
            //Fills modal body with recipe info
            //Passed in from first ajax call ( createRecipeModal() )
            $("#recipeInfoDiv").html("<br/>" + data.summary)
                .append("<hr class='recipeModalDivider'>")
                
                .append("Vegan? " + (recipe.vegan ? "Yes" : "No"))
                .append("<br/>Vegetarian? " + (recipe.vegetarian ? "Yes" : "No"))
                .append("<br/><br/>Serves " + recipe.servings)
                
                //----------------------------------------------------------------------------------------------------
                // Case existsed where preparation and/or cooking minutes was "undefined"
                // Displayed as "undefined minutes" so ternary operators help to ensure that there is proper output
                //---------------------------------------------------------------------------------------------------
                
                //If at least one of the times is defined
                .append( (recipe.preparationMinutes || recipe.cookingMinutes || recipe.readyInMinutes) ? "<hr class='recipeModalDivider'>" : "")
                
                //If the respective time is defined, it will output the proper message (with appropriate line break presence)
                //Otherwise, it will not output anything
                .append(recipe.preparationMinutes ? ("Preparation time: " + recipe.preparationMinutes + " minutes") : "")
                .append(recipe.cookingMinutes ? (recipe.preparationMinutes ? ("<br/>Cooking time: " + recipe.cookingMinutes + " minutes") : ("Cooking time: " + recipe.cookingMinutes + " minutes")) : "")
                .append(recipe.readyInMinutes ? (recipe.preparationMinutes || recipe.cookingMinutes ? ("<br/>Ready In: " + recipe.readyInMinutes + " minutes") : ("Ready In: " + recipe.readyInMinutes + " minutes")) : "");
                
                if(recipe.instructions)
                {
                    $("#recipeInfoDiv").append("<hr class='recipeModalDivider'>" + recipe.instructions)
                        .css("font-size", "18px");
                }
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            alert("error");   
            console.log(data);
            console.log(status);
        }
    });
    
}