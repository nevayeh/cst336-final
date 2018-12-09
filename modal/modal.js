function createTestModal()
{
    console.log("Creating test modal");
    $("#recipeModal").modal('show');
    $("#recipeModalLabel").html("Recipe name");
    $("#recipeInfoDiv").html("Information");
}

function logInModal()
{
    console.log("Somehow Create a Log In Modal Here");
    
    $("#logInModal").modal('show');
    
}


function createModal(id)
{
    console.log("creating modal. id: " + id);
    
    $("#recipeModal").modal('show');
    $("#recipeModalLabel").html(""); //prevents both loading and recipe info showing (after clicking on another recipe)
    $("#recipeImgDiv").html('<img style="width: 100px; height: 100px" src="img/loading.gif" alt="loading"/>');
    $("#recipeInfoDiv").html("");
    
    $.ajax(
    {
        type: "get",
        url: "api/getRecipeInfo.php",
        dataType: "json",
        data: {"id": id} ,
        success: function(data, status)
        {
            console.log("SUCCESS");
            console.log(data);
            
            $("#recipeModalLabel").html(data.title);
            $("#recipeImgDiv").html(""); //clears loading.gif
            $("#recipeInfoDiv").html(data.summary)
                .css("font-size", "20px");
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