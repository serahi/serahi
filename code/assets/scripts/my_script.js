$(document).ready(function(){
  
  
  $.validator.addMethod("email", function(value, element) 
{ 
return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
}, "Please enter a valid email address.");
  


  $("#username").focus(function(){
    if( $(this).val() == "نام کاربری"){
        $(this).val("");
    }
  });
 
  $("#username").blur(function(){
    if($(this).val() == ""){
        $(this).val("نام کاربری");
    }
  });
  
  
  
  $("#password").focus(function(){
    if( $(this).val() == "password"){
        $(this).val("");
    }
    });
  
  $("#password").blur(function(){
    if($(this).val() == ""){
        $(this).val("password");
    }
    });
  
  $("#first_name").blur(function(){
    var $first_name_val = $(this).val();
    if( $first_name_val.length < 3 ){
      $("#reg_btm").attr("disabled", true); 
      $("#first_name_error").html("نام شما باید حداقل ۳ حرف داشته باشد.");
    }else{
      $("#first_name_error").html("");
      $("#reg_btm").attr("disabled", false); 
    } 
  });
    
    $("email").blur(function(){
      
      });
  
  
});


