{block name=main_content}

<div id="sign_up_form">
    <?php
    
        echo validation_errors('<div class="error_msg">' , '</div>');
    
        echo form_open('user/login/register');
		
		echo form_input('username', 'نام کاربری' , 'id="username" class="check"');
        echo '<div class="error_msg" id="username_error"> </div>';
		
		echo form_input('password','رمز عبور', 'id="password" class="check pass"');
        echo '<div id="password_error"> </div>';
        echo form_input('passconf', 'تکرار رمز عبور', 'id="c_password"  class="check pass"');
        echo '<div id="c_password_error"> </div>';
		
		echo form_input('first_name','نام' , 'id="first_name" class="check"');
        echo '<div class="error_msg" id="first_name_error"> </div>';
         
        echo form_input('last_name', 'نام‌خانوادگی', 'id="last_name" class="check"');
        echo '<div class="error_msg" id="last_name_error"> </div>';
		
		echo form_input('email', 'آدرس پست‌الکترنیکی', 'id="email"  class="check"');
        echo '<div id="email_error"> </div>';
        
        
        /*
        echo form_input('mobile', 'شماره تلفن همراه', 'id="mobile" class="check"');
        echo '<div id="mobile_error"> </div>';
  
        echo form_input('state' , 'استان محل سکونت', 'id="state" class="check"');
        echo '<div id="state_error"> </div>';
        
        echo form_input('city' , 'شهر محل سکونت', 'id="city" class="check"');
        echo '<div id="city_error"> </div>';
        
        echo form_input('address' , 'آدرس دقیق محل سکونت', 'id="address" class="check"');
        echo '<div id="address_error"> </div>';
        
        echo form_input('postal_code','کدپستی', 'id="postal_code"');
        echo '<div id="postal_code_error"> </div>';
        */
        echo '<div id="register_msg">' . 'لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.' . '<br/>' . anchor('site/rules', 'قوانین سایت', 'id="register_btm"') . '<br/> <br/>' . form_checkbox('confirmation', '') . 'قوانین سایت را مطالعه کرده و قبول می‌کنم' . '</div>';
        
        echo form_submit('submit','ثبت‌نام', 'id="reg_btm"');
        
        echo form_close();
    ?>
    
</div>

{/block}