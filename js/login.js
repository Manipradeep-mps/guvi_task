$(document).ready(function(){
    $('#loginsubmit').click(function(){
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: "./php/login.php",
            type:"POST",
            data: {
                email: email,
                password: password
            },
            success: function(response){
                var responseObject = JSON.parse(response);                    
                if(responseObject.status === "Success")
                {
                    localStorage.setItem('userinfo',responseObject.jwt);
                    window.location.href = "./profile.html";
                }
                else
                {
                    alert(response);
                  
                    
                }
             },
            error: function(xhr, status, error){

                alert("Something went wrong");
            }
        });
    });
});
