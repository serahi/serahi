{block name=title}
فرم ثبت‌ نام مشتریان‌
{/block}

{block name=main_content}
<div id="sign_up_form">
	<?php

	echo validation_errors('<div class="error_msg">', '</div>');

	if (isset($user_not_unique))
		echo '<div class="error_msg">' . $user_not_unique . '</div>';
	?>
	<form class="forms" action="user/login/register" method="post">
		<input id="username" type="text"  class="check" name="username" value="<?php  echo set_value('username', 'نام کاربری');?>"/>
		<input id="password" type="text" class="check pass" name="password" value="رمز عبور"/>
		<input id="c_password" type="text" class="check pass" name="passconf" value="تکرار رمز عبور"/>
		<input id="first_name" type="text" class="check" name="first_name" value="<?php echo  set_value('first_name', 'نام');?>"/>
		<input id="last_name" type="text" class="check" name="last_name" value="<?php echo set_value('last_name', 'نام خانوادگی');?>"/>
		<input id="email" type="text" class="check" name="email" value="<?php echo  set_value('email', 'آدرس پست‌الکترونیکی');?>"/>
		<input type="hidden" value="c" name="ut">
		<div id="register_msg">لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.<br/>
			<a href="site/rules" id="register_btm">قوانین سایت</a><br/>
			<br/><input class="confirmation" type="checkbox" value="" name="confirmation">
			<label for="confirmation">قوانین سایت را مطالعه کرده و قبول می&zwnj;کنم</label>
		</div>
		<input id="reg_btm" type="submit" value="ثبت‌نام" name="submit">
	</form>
	<?php
	//$attributes = array('class' => 'forms');
	//echo form_open('user/login/register', $attributes);
	//echo form_input('username', set_value('username', 'نام کاربری'), 'id="username" class="check"');

	//echo form_input('password', 'رمز عبور', 'id="password" class="check pass"');
	//echo form_input('passconf', 'تکرار رمز عبور', 'id="c_password"  class="check pass"');

	//echo form_input('first_name', set_value('first_name', 'نام'), 'id="first_name" class="check"');

	//echo form_input('last_name', set_value('last_name', 'نام خانوادگی'), 'id="last_name" class="check"');

	//echo form_input('email', set_value('email', 'آدرس پست‌الکترونیکی'), 'id="email"  class="check"');

	//echo form_hidden('ut', 'c');

	//echo '<div id="register_msg">' . 'لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.' . 
	//'<br/>' . anchor('site/rules', 'قوانین سایت', 'id="register_btm"') . '<br/> 
	//<br/>' . form_checkbox('confirmation', '', FALSE, 'class="confirmation"') . 
	//'<label for="confirmation">قوانین سایت را مطالعه کرده و قبول می‌کنم</label>' . '</div>';

	//echo form_submit('submit', 'ثبت‌نام', 'id="reg_btm"');

	//echo form_close();
	?>
</div>
{/block}