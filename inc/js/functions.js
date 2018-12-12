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





function saveRecipe(username)
{
    // alert("saving recipe (WIP)");
    
    console.log("saving recipe, going to go into getUserFromDB.php");
    console.log("username given: " + username);
    console.log(typeof username);
    
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/getUserIDFromDB.php",
        dataType: "json",
        data: {"user": username}, 
        success: function(data, status)
        {
            // console.log(data);
            // console.log(typeof data);
            
            // console.log(data[0].userid);
            
            var userid = data[0].userid;
            var recipeName = $("#recipeModalLabel").text();
            var recipeImgURL = $('#recipeImgDiv img').attr('src');
            var recipeDescription = $("#recipeInfoDiv").text();
            
            
            // console.log(userid);
            // console.log(recipeName);
            // console.log(recipeImgURL);
            // console.log(recipeDescription);
           
            insertRecipeIntoDB(userid, recipeName, recipeImgURL, recipeDescription); 
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            alert("error saving recipe");   
            console.log("ERROR saving recipe");
            console.log(data);
        }
    });
    
    
    
    
    
    // $("#recipeModal").modal('hide');
    
}    
    
    
function insertRecipeIntoDB(userid, recipeName, recipeImgURL, recipeDescription)
{
    $.ajax(
    {
        type: "get",
        url: "inc/ajax/insertRecipeIntoDB.php",
        dataType: "json",
        data: {"id": userid, "name": recipeName, "img": recipeImgURL, "desc": recipeDescription}, 
        success: function(data, status)
        {
            
            
            // console.log(userid);
            // console.log(recipeName);
            // console.log(recipeImgURL);
            // console.log(recipeDescription);
           
            // insertRecipeIntoDB(userid, recipeName, recipeImgURL, recipeDescription); 
            
            console.log("inserted into db");
            console.log("succes message: " + data);
        }, 
        //optional, used for debugging purposes
        complete: function(data, status)
        {
            //alert(status);
        },  
        error: function(data, status)
        {
            // alert("error insert into db");   
            // console.log("ERROR inserting into db");
            // console.log(data.responseText);
        }
    });
}



$("#cookTime").on("click", function(){
   if($(this).is(":checked")){
       console.log("CHECKED");
       $("#base").html("");
   }
});


