function createLogInModal(text)
{
    $("#logInModal").modal('show');
}

//Clears modal after closing
//(If they type stuff in and then close it withouto logging in)
$('#logInModal').on('hidden.bs.modal', function()
{
    $(this)
        .find("input,textarea,select")
            .val('')
    $("#logInVerification").html("");
});
    
    
function createRecipeModal(id, loggedIn)
{
    $("#recipeModal").modal('show');
    $("#recipeModalLabel").html("");
    $("#recipeImgDiv").html('<img style="width: 100px; height: 100px" src="img/loading-circle.gif" alt="loading"/>');
    $("#recipeInfoDiv").html("");
    
    //Makes sure there are no residual buttons displayed
    $("#saveRecipeButton").css("display", "none");
    $("#logInMessageButton").css("display", "none");
    $("#recipeSavedMessageButton").css("display", "none");
    $("#alreadySavedMessageButton").css("display", "none");
    $("#doneButton").css("display", "none");
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/getRecipeInstructions.php",
        dataType: "json",
        data: {"id": id} ,
        success: function(data, status)
        {
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
            
            getRecipeDescription(id, recipeInformation, loggedIn);
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error instructions");   
        }
    });
}

//Fills modal body with recipe info
//Passed in from first ajax call ( createRecipeModal() )
function getRecipeDescription(id, recipe, loggedIn)
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/getRecipeInfo.php",
        dataType: "json",
        data: {"id": id} ,
        success: function(data, status)
        {
            $("#recipeModalLabel").html(recipe.title);
            $("#recipeImgDiv").html("<img id='" + id + "' style='width:400px;height:250px' src='" + recipe.image + "' alt='" + recipe.title + "'/>");
            
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
                
                if(loggedIn)
                    $("#saveRecipeButton").css("display", "block");
                else
                    $("#logInMessageButton").css("display", "block");
                
                $("#doneButton").css("display", "block");
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error description");   
        }
    });
    
}


function createEditRecipeModal(recipeid)
{
    var loggedUser = $("#hiddenUserID").val();
    
    $("#hiddenRecipeID").val(""); //Resets hidden recipe id
    $("#hiddenRecipeName").val(""); //Resets hidden recipe name
    
    $("#editRecipeModal").modal('show');
    $("#editRecipeModalLabel").html("");
    $("#editRecipeImgDiv").html('<img style="width: 100px; height: 100px" src="img/loading-circle.gif" alt="loading"/>');
    $("#editRecipeInfoDiv").html("");
    $("#deleteRecipeButton").css("display", "none");
    $("#saveChangesButton").css("display", "none");
    $("#changesSavedButton").css("display", "none");
    $("#closeButton").css("display", "none");
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/database/getRecipeFromDB.php",
        dataType: "json",
        data: {"userid": loggedUser, "recipeid": recipeid},
        success: function(data, status)
        {
            $("#hiddenRecipeID").val(data[0].recipeid);
            $("#hiddenRecipeName").val(data[0].name);
            
            $("#editRecipeModalLabel").html(data[0].name)
                .attr("contenteditable", "true");
            
            $("#editRecipeImgDiv").html('<img style="width:400px;height:250px" src="' + data[0].imageURL + '" alt="' + data[0].name + '">');

            $("#editRecipeInfoDiv").html(data[0].description)
                .attr("contenteditable", "true");

            $("#deleteRecipeButton").css("display", "block");
            $("#saveChangesButton").css("display", "block");
            $("#closeButton").css("display", "block");
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error edit recipe");
        }
    });
}