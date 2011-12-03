{block name=title}
فرم ثبت‌ نام فروشنده‌
{/block}
{block name=main_content}
<div id="sign_up_form">
	<?php

	echo validation_errors('<div class="error_msg">', '</div>');

	if (isset($user_not_unique))
		echo '<div class="error_msg">' . $user_not_unique . '</div>';
	?>
	<form action="{$base_url}user/register" class="forms submit_form" method="post">
		<input id="username" type="text"  class="check validate[required]" name="username" value="<?php echo set_value('username', 'نام کاربری');?>"/>
		<input id="password" type="text" class="check pass validate[required]" name="password" value="رمز عبور"/>
		<input id="c_password" type="text" class="check pass validate[required,equals[password]]" name="passconf" value="تکرار رمز عبور"/>
		<input id="first_name" type="text" class="check validate[required]" name="first_name" value="<?php echo set_value('first_name', 'نام');?>"/>
		<input id="last_name" type="text" class="check validate[required]" name="last_name" value="<?php echo set_value('last_name', 'نام خانوادگی');?>"/>
		<input id="email" type="text" class="check validate[required,custom[email]]" name="email" value="<?php echo set_value('email', 'آدرس پست‌الکترونیکی' );?>"/>
		<input id="phone" type="text" class="check validate[required]" name="phone" value="شماره‌ی تماس"/>
		<input id="address" type="text" class="check validate[required]" name="address" value="آدرس دقیق"/>
                <div id="map">    
                    <iframe width="325" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/?ie=UTF8&amp;hq=&amp;hnear=Tehran,+Iran&amp;ll=35.74228,51.506674&amp;spn=0.009614,0.013797&amp;t=m&amp;z=16&amp;vpsrc=6&amp;output=embed">
                    </iframe><br />
                </div>
                <input id="location" type="hidden" name="location"/>
                <input id="seller_display_name" type="text" class="check" name="seller_display_name" value="نام شرکت یا فروشگاه شما"/>
		<input type="hidden" value="s" name="ut">
		<div id="register_msg">لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.<br/>
			<a href="site/rules" id="register_btm">قوانین سایت</a><br/>
			<br/><input class="confirmation" type="checkbox" value="" name="confirmation">
			<label for="confirmation">قوانین سایت را مطالعه کرده و قبول می&zwnj;کنم</label>
		</div>
		<input id="reg_btm" class="submit_btm" type="submit" value="ثبت‌نام" name="submit">
	</form>
</div>
{/block}