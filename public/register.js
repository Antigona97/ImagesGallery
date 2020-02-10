$('document').ready(function(){});
 $('#submitButton').click(function register(){
    alert("HELLOO");
    var data=$('.form-class').serialize();
    console.log(data);
    $.ajax({
        url:'registerUser.php',
        type:'POST',
        data: data,
        success: function(data){
           $('.login').html(data);
        },
        error: function (thrownError) {
         alert("Errorrr");
       }
    });
 });