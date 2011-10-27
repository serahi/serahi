{block name=main_content}

<div id="sign_up_form">
    <?php
    
        echo validation_errors('<div class="error_msg">' , '</div>');
    
        echo form_open('login/register');
        
        echo form_input('first_name','نام' , 'id="first_name"');
        echo '<div class="error_msg" id="first_name_error"> </div>';
         
        echo form_input('last_name', 'نام‌خانوادگی', 'id="last_name"');
        echo '<div class="error_msg" id="last_name_error"> </div>';
        
        echo form_input('username', 'نام کاربری' , 'id="username"');
        echo '<div class="error_msg" id="username_error"> </div>';
        
        echo form_password('password','password', 'id="password"');
        echo '<div id="password_error"> </div>';
        echo form_password('c_password', 'password', 'id=c_password');
        echo '<div id="c_password_error"> </div>';
        
        echo form_input('mobile', 'شماره تلفن همراه', 'id="mobile"');
        echo '<div id="mobile_error"> </div>';
        
        echo form_input('email', 'آدرس پست‌الکترنیکی', 'id="email"');
        echo '<div id="email_error"> </div>';
        
        echo form_input('state' , 'استان محل سکونت', 'id="state"');
        echo '<div id="state_error"> </div>';
        
        echo form_input('city' , 'شهر محل سکونت', 'id="city"');
        echo '<div id="city_error"> </div>';
        
        echo form_input('address' , 'آدرس دقیق محل سکونت', 'id="address"');
        echo '<div id="address_error"> </div>';
        
        echo form_input('postal_code','کدپستی', 'id="postal_code"');
        echo '<div id="postal_code_error"> </div>';
        
        echo '<div id="register_msg">' . 'لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.' . '<br/>' . anchor('site/rules', 'قوانین سایت', 'id="register_btm"') . '<br/> <br/>' . form_checkbox('confirmation', '') . 'قوانین سایت را مطالعه کرده و قبول می‌کنم' . '</div>';
        
        echo form_submit('submit','ثبت‌نام', 'id="reg_btm"');
        
        echo form_close();
    ?>
    
</div>
{/block}
