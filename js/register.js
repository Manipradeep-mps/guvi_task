$(document).ready(function(){
    $('#submit').click(function(){
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: "./php/register.php",
            type:"POST",
            data: {
                name: name,
                email: email,
                password: password
            },
            success: function(response){
                if (response === "Success")
                {
                    window.location.href = "./login.html";
                } 
                else {
        
                    alert(response);
                }
             },
            error: function(xhr, status, error){

                alert("Something went wrong");
            }
        });
    });
});
