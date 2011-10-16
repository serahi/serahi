$(document).ready(function(){
  $("#username").click(function(){
    if( $(this).val() == "نام کاربری"){
        $(this).val("");
    }  
  });
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
  $("#username").unfocus(function(){
    if($(this).val() == ""){
        $(this).val("نام کاربری");
    }
  });
  
  
  
    $("#password").click(function(){
        if( $(this).val() == "password"){
            $(this).val("");
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
  $("#password").unfocus(function(){
    if($(this).val() == ""){
        $(this).val("password");
    }
    });
  
  
});