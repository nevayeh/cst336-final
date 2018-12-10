$("#signInButton").click(function()
{
    console.log("Js is being called");
    $.ajax({
        type: "get",
        url: "api/checklogin.php",
        data: {"username": $("#formGroupUsernameInput").val(),
        "password": $("#formGroupPasswordInput").val()},
        datatype: "json",
        beforeSend: function() {
            //console.log(username);
            //console.log(password);
            // $("#modal-body").html("<img src='img/loading.gif'/>");
            // console.log("before send code is running");
            // $(".modal-title").html("formGroupPasswordInput");
        },
        success: function(data, status) {
            console.log('success')
            console.log(data);
            console.log(typeof data);
            
            //INDEXER
            // console.log("username: " + data['username']);
            // console.log("user exists: " + data['found']);
            
            //DOT
            console.log("username: " + data.username);
            console.log("found: " + data.found);
            
            
            if(data == "true")
            {
                console.log();
                $("#logInModal").modal('hide');
            }
            
            
            
        },
        fail: function(status) {
            console.log('fail');
            console.log(data);
            
        }
    });
});
    // For now, it just closes the modal, but we would want to add credential verification here
    // want this button to send username and password to database to check if they are there, if so, sign in so that they can save recipe in database
    
//     $("#logInModal").modal('hide');
// });