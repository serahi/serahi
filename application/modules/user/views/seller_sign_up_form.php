{block name=title}
<title>فرم ثبت‌ نام فروشنده‌</title>
{/block}
{block name=main_content}

<div id="sign_up_form">
    <?php
    
        echo validation_errors('<div class="error_msg">' , '</div>');
		
		if(isset($user_not_unique))
			echo '<div class="error_msg">' . $user_not_unique . '</div>'; 
		$attributes = array('class' => 'forms');
        echo form_open('user/login/register', $attributes);
		
		echo form_input('username',set_value('username','نام کاربری'), 'id="username" class="check"');
        echo '<div class="error_msg" id="username_error"> </div>';
		
		echo form_input('password','رمز عبور', 'id="password" class="check pass"');
        echo '<div id="password_error"> </div>';
        echo form_input('passconf', 'تکرار رمز عبور', 'id="c_password"  class="check pass"');
        echo '<div id="c_password_error"> </div>';
		
		echo form_input('first_name',set_value('first_name','نام') , 'id="first_name" class="check"');
        echo '<div class="error_msg" id="first_name_error"> </div>';
         
        echo form_input('last_name', set_value('last_name','نام خانوادگی') ,'id="last_name" class="check"');
        echo '<div class="error_msg" id="last_name_error"> </div>';
		
		echo form_input('email', set_value('email', 'آدرس پست‌الکترنیکی'), 'id="email"  class="check"');
        echo '<div id="email_error"> </div>';
        
        
        echo form_input('phone', 'شماره‌ی تماس', 'id="phone" class="check"');
        echo '<div id="phone_error"> </div>';
  
        
        echo form_input('address' , 'آدرس دقیق', 'id="address" class="check"');
        echo '<div id="address_error"> </div>';
		
		echo form_input('seller_display_name' , 'نام شرکت یا فروشگاه شما', 'id="seller_display_name" class="check"');
        echo '<div id="address_error"> </div>';
        
		echo form_hidden('ut','s');        
        
        echo '<div id="register_msg">' . 'لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.' . '<br/>' . anchor('site/rules', 'قوانین سایت', 'id="register_btm"') . '<br/> <br/>' . form_checkbox('confirmation', '') . 'قوانین سایت را مطالعه کرده و قبول می‌کنم' . '</div>';
        
        echo form_submit('submit','ثبت‌نام', 'id="reg_btm"');
        
        echo form_close();
    ?>
    
</div>

{/block}