function createLogInModal(text)
{
    console.log("showing login modal");
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
    console.log("creating modal for id:" + id);
    console.log("loggedIn: " + loggedIn);
    
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
            alert("error instructions");   
            console.log("ERROR instructions");
            console.log(data);
        }
    });
}

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
            alert("error description");   
            console.log(data);
            console.log(status);
        }
    });
    
}


function createEditRecipeModal(name)
{
    $("#editRecipeModal").modal('show');
    $("#editRecipeModalLabel").html(name);
    $("#editRecipeImgDiv").html('<img style="width: 100px; height: 100px" src="img/loading-circle.gif" alt="loading"/>');
    $("#editRecipeInfoDiv").html("");
    $("#deleteRecipeButton").css("display", "none");
    $("#saveChangesButton").css("display", "none");
    $("#closeButton").css("display", "none");
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/getRecipeFromDB.php",
        dataType: "json",
        // data: {"id": id} ,
        data: {},
        success: function(data, status)
        {
            $("#editRecipeImgDiv").html('');

            $("#editRecipeInfoDiv").html(data);

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
            alert("error edit recipe");   
            console.log("ERROR edit recipe");
            console.log(data);
        }
    });
}