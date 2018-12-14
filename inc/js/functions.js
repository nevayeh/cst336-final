//Handles form logic of log in modal
$("#signInButton").click(function()
{
    var keepFact = $("#factText").text();
    
    $.ajax({
        type: "get",
        url: "inc/ajax/checklogin.php",
        data:{
            "username": $("#formGroupUsernameInput").val(),
            "password": $("#formGroupPasswordInput").val(),
        },
        datatype: "json",
        success: function(data, status)
        {
            var jsonData = jQuery.parseJSON(data);
            
            if(jsonData.found == "true")
            {
                //Logs in user using their unique unsername
                //Stores fact into session so it doesn't change after the reload (next line)
                login(jsonData.username, keepFact); 
                location.reload(); //refreshes page to reload nav bar text
                
                $("#logInModal").modal('hide');
            }
            else
            {
                $("#logInVerification").html('Your username and/or password do not match our records')
                    .css("color", "red")
                    .css("font-size", "20px")
                    .css("padding-bottom", "20px");
            }
        },
        fail: function(data, status)
        {
            // alert('fail sign in ajax');
        },
        complete: function()
        {
            $("#formGroupUsernameInput").html("");
            $("#formGroupPasswordInput").html("");
        }
    });
    
    
});

//Helper function to log user in, also stores fact into session
function login(username, fact)
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/loginUser.php",
        dataType: "json",
        data: {"username" : username, "fact": fact},
        success: function(data, status)
        {
            
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error login");   
        }
    });
    
}

//Helper function to log user out, also stores fact into session
function logout()
{
    var keepFact = $("#factText").text();

    $.ajax(
    {
        type: "get",
        url: "inc/ajax/logoutUser.php",
        dataType: "json",
        data: {"fact" : keepFact}, //stores fact into session
        success: function(data, status)
        {
            //If already on index.php, will reload page
            if($(location).attr('href').search("index.php") > -1) 
            {
                location.reload(); //refreshes page to reload nav bar text
            }
            else
            {
                window.location = "index.php";
                
                // Since the other pages don't have a food fact div, nothing was passed into "keepFact"
                // ^ This causes the Food Fact div to be empty after logging out
                // This gets a new food fact and stores it in $_SESSION (pseudo keepFact)
                getNewFoodFact();
            }
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error logout");   
        }
    });
}

function getNewFoodFact()
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/getNewFoodFact.php",
        dataType: "json",
        data: {}, //stores fact into session
        success: function(data, status)
        {
            
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error food fact");
        }
    });
}


$("#saveRecipeButton").click(function()
{
    var loggedUser = $("#hiddenUsername").val();
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/database/getUserIDFromDB.php",
        dataType: "json",
        data: {"user": loggedUser}, 
        success: function(data, status)
        {

            var userid = data[0].userid;
            
            var recipeId = $("#recipeImgDiv img").attr("id");
            var recipeName = $("#recipeModalLabel").text();
            var recipeImgURL = $('#recipeImgDiv img').attr('src');
            var recipeDescription = $("#recipeInfoDiv").html();
            
            insertRecipeIntoDB(userid, recipeId, recipeName, recipeImgURL, recipeDescription); 
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {

        },  
        error: function(data, status)
        {
            // alert("error saving recipe");   
        }
    });
    
});

    
function insertRecipeIntoDB(userid, recipeId, recipeName, recipeImgURL, recipeDescription)
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/database/insertRecipeIntoDB.php",
        dataType: "json",
        data: {"id": userid, "recipeId": recipeId, "name": recipeName, "img": recipeImgURL, "desc": recipeDescription}, 
        success: function(data, status)
        {
            if(data == "Duplicate")
            {
                $("#saveRecipeButton").css("display", "none");
                $("#alreadySavedMessageButton").css("display", "block");
            }
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // Not sure why, but ends up in error function after successfully inserting into database
            $("#saveRecipeButton").css("display", "none");
            $("#recipeSavedMessageButton").css("display", "block");
            
            logActivity(userid, "Saved", recipeName);
        }
    });
}

$("#saveChangesButton").click(function()
{
    var userid = $("#hiddenUserID").val();
    var recipeid = $("#hiddenRecipeID").val();
    
    var recipeNewName = $("#editRecipeModalLabel").text();
    //Cannot change image for now
    var recipeNewDescription = $("#editRecipeInfoDiv").html();
    
    var recipeName = $("#hiddenRecipeName").val();
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/database/editRecipeInDB.php",
        dataType: "json",
        data: {"user": userid, "recipe": recipeid, "newName": recipeNewName, "newDesc": recipeNewDescription}, 
        success: function(data, status)
        {
            $("#saveChangesButton").css("display", "none");
            $("#changesSavedButton").css("display", "block");
            
            logActivity(userid, "Edited", recipeName);
            
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error saving recipe");   
        }
    });
});

//Unsets the "changes saved" button and resets the "save changes" button so the user can
//keep changing without closing the modal if they want
// $("editRecipeInfoDiv").click(function()
$("#editRecipeInfoDiv").focus(resetSaveChangesButton);
$("#editRecipeModalLabel").focus(resetSaveChangesButton);

function resetSaveChangesButton()
{
    if($("#changesSavedButton").css("display") == "block")
    {
        $("#changesSavedButton").css("display", "none");
        $("#saveChangesButton").css("display", "block");
    }
}

$('#editRecipeModal').on('hidden.bs.modal', function ()
{
    location.reload(); 
});

//Both modals on same z-index by default
//Puts the z-index of the first modal below 1039 so it falls behind the backdrop when the second modal opens
$('#confirmationModal').on('show.bs.modal', function ()
{
    $('#editRecipeModal').css('z-index', 1039);
});

//Puts the z-index of the first modal back to default 1040 when second modal is hidden
$('#confirmationModal').on('hidden.bs.modal', function ()
{
    $('#editRecipeModal').css('z-index', 1041);
});


$("#deleteRecipeButton").click(function()
{
    $("#confirmationModal").modal("show");
});


$("#yesButton").click(function()
{
    $("#editRecipeModal").modal("hide");
    
    var userid = $("#hiddenUserID").val();
    var recipeid = $("#hiddenRecipeID").val();
    
    var recipeName = $("#hiddenRecipeName").val();
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/database/removeRecipeFromDB.php",
        dataType: "json",
        data: {"id": userid, "recipeId": recipeid}, 
        success: function(data, status)
        {
            logActivity(userid, "Deleted", recipeName);

        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            
        },  
        error: function(data, status)
        {
            // alert("error Deeleting");
        }
    });
});

function logActivity(user, activity, recipeName)
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/database/logActivityIntoDB.php",
        dataType: "json",
        data: {"id": user, "act": activity, "recipe": recipeName}, 
        success: function(data, status)
        {
            
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error logging");
        }
    });
}
