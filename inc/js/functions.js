//Handles form logic of log in modal
$("#signInButton").click(function()
{
    console.log("Sign in button clicked, checking database");
    
    var keepFact = $("#factText").text();
    
    $.ajax({
        type: "get",
        url: "api/checklogin.php",
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
        url: "api/loginUser.php",
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
        url: "api/logoutUser.php",
        dataType: "json",
        data: {"fact" : keepFact}, //stores fact into session
        success: function(data, status)
        {
            console.log("data from logoutUser.php: " + data); 
            location.reload(); //refreshes page to reload nav bar text
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
<<<<<<< HEAD:js/functions.js
=======

$("#saveRecipeButton").click(function()
{
    window.location("recipes.php");
});


$("#cookTime").on("click", function(){
   if($(this).is(":checked")){
       console.log("CHECKED");
       $("#base").html("");
   }
});
>>>>>>> 29c3d4ee895dbda5d4526006e9cedca32cbaf8dd:inc/js/functions.js
