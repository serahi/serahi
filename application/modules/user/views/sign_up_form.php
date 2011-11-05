{block name=title}
فرم ثبت‌ نام مشتریان‌
{/block}

{block name=main_content}
<div id="sign_up_form">
	<?php

	echo validation_errors('<div class="error_msg">', '</div>');

	if (isset($user_not_unique))
		echo '<div class="error_msg">' . $user_not_unique . '</div>';
	$attributes = array('class' => 'forms');
	echo form_open('user/login/register', $attributes);

	echo form_input('username', set_value('username', 'نام کاربری'), 'id="username" class="check"');

	echo form_input('password', 'رمز عبور', 'id="password" class="check pass"');
	echo form_input('passconf', 'تکرار رمز عبور', 'id="c_password"  class="check pass"');

	echo form_input('first_name', set_value('first_name', 'نام'), 'id="first_name" class="check"');

	echo form_input('last_name', set_value('last_name', 'نام خانوادگی'), 'id="last_name" class="check"');

	echo form_input('email', set_value('email', 'آدرس پست‌الکترونیکی'), 'id="email"  class="check"');

	echo form_hidden('ut', 'c');

	echo '<div id="register_msg">' . 'لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.' . '<br/>' . anchor('site/rules', 'قوانین سایت', 'id="register_btm"') . '<br/> <br/>' . form_checkbox('confirmation', '', FALSE, 'class="confirmation"') . '<label for="confirmation">قوانین سایت را مطالعه کرده و قبول می‌کنم</label>' . '</div>';

	echo form_submit('submit', 'ثبت‌نام', 'id="reg_btm"');

	echo form_close();
	?>
</div>
{/block}