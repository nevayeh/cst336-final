function createModal()
{
    console.log("creating modal");
    
    $("#recipeModal").show();
    // $("#modalBody").html("<img src='img/loading.gif'/>");
    
    $("#recipeModalLabel").html("Recipe name");
    $("#recipeInfoDiv").html("Information");
    
    /*
    $.ajax(
    {
        type: "get",
        url: "api/getRecipeInfo.php",
        dataType: "json",
        data: {"name": name} ,
        success: function(data, status)
        {
            $("#recipeModalLabel").html(data[0].name);
            $("#recipeImgDiv").html("<img style='width: 250px' src='img/" + data[0].name.toLowerCase() + ".jpg'/>")
                .css("display", "inline-block");
            
            $("#recipeInfoDiv").html("Age: " + (currentYear - data[0].yob) + "<br/>")
                .append("Breed: " + data[0].breed + "<br/>")
                .append(data[0].description + "</div>")
                .css("display", "inline-block")
                .css("text-align", "left")
                .css("padding-left", "25px");
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
    */
}