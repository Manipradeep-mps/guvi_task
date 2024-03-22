$(document).ready(function(){



    $.ajax({
        url: "./php/profile.php",
        type:"POST",
        data: {
            jwt:localStorage.getItem('userinfo')
        },
        success: function(response){
            console.log(response);
         },
        error: function(xhr, status, error){

            alert("Something went wrong");
        }
    });
    $('#logoutbutton').click(function(){
        localStorage.removeItem('userinfo');
        window.location.href = "./login.html";
    })


    
})