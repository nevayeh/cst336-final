//Handles form logic of log in modal
$("#signInButton").click(function()
{
    console.log("Sign in button clicked, checking database");
    
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
            console.log('success, went into checklogin.php')
            
            var jsonData = jQuery.parseJSON(data);
            // console.log("username? " + jsonData.username);
            // console.log("found? " + jsonData.found);
            
            console.log("FACT: " + keepFact);
            
            if(jsonData.found == "true")
            {
                console.log("good login");
                
                //Logs in user using their unique unsername
                //Stores fact into session so it doesn't change after the reload (next line)
                login(jsonData.username, keepFact); 
                location.reload(); //refreshes page to reload nav bar text
                
                $("#logInModal").modal('hide');
            }
            else
            {
                console.log("bad login");
                
                $("#logInVerification").html('Your username and/or password do not match our records')
                    .css("color", "red")
                    .css("font-size", "20px")
                    .css("padding-bottom", "20px");
            }

        },
        fail: function(data, status)
        {
            alert('fail sign in ajax');
            console.log(data);
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
    console.log("logging in " + username);
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/loginUser.php",
        dataType: "json",
        data: {"username" : username, "fact": fact},
        success: function(data, status)
        {
            console.log("data from loginUser.php: " + data);
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            alert("error login");   
            console.log("error login");
            console.log(data);
        }
    });
    
}

//Helper function to log user out, also stores fact into session
function logout()
{
    console.log("logging out");
    
    var keepFact = $("#factText").text();

    $.ajax(
    {
        type: "get",
        url: "inc/ajax/logoutUser.php",
        dataType: "json",
        data: {"fact" : keepFact}, //stores fact into session
        success: function(data, status)
        {
            console.log("data from logoutUser.php: " + data); 
            
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
            alert("error logout");   
            console.log("ERROR logout");
            console.log(data);
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
            console.log("data from getNewFoodFact.php: " + data); 
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            alert("error food fact");   
            console.log("ERROR food fact");
            console.log(data);
        }
    });
}



$("#saveRecipeButton").click(function()
{
    var loggedUser = $("#hiddenUsername").val();
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/getUserIDFromDB.php",
        dataType: "json",
        data: {"user": loggedUser}, 
        success: function(data, status)
        {

            var userid = data[0].userid;
            
            var recipeId = $("#recipeImgDiv img").attr("id");
            var recipeName = $("#recipeModalLabel").text();
            var recipeImgURL = $('#recipeImgDiv img').attr('src');
            var recipeDescription = $("#recipeInfoDiv").text();
            
            insertRecipeIntoDB(userid, recipeId, recipeName, recipeImgURL, recipeDescription); 
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error saving recipe");   
            console.log("ERROR saving recipe");
            console.log(data);
        }
    });
    
});

    
function insertRecipeIntoDB(userid, recipeId, recipeName, recipeImgURL, recipeDescription)
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/insertRecipeIntoDB.php",
        dataType: "json",
        data: {"id": userid, "recipeId": recipeId, "name": recipeName, "img": recipeImgURL, "desc": recipeDescription}, 
        success: function(data, status)
        {
            if(data == "Duplicate")
            {
                // console.log("Yeet")
                
                $("#saveRecipeButton").css("display", "none");
                $("#alreadySavedMessageButton").css("display", "block");
            }
            else
            {
                console.log("Yeet yeet");
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
        }
    });
}



$("#cookTime").on("click", function(){
   if($(this).is(":checked")){
       console.log("CHECKED");
       $("#base").html("");
   }
});

