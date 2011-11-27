{block name=title}
ورود به سیستم‌
{/block}

{block name=main_content}
<div id="login_form">
	<form action="{$base_url}user/login_check" class="forms submit_form" method="post">
		<div class='error_msg'>
			{if isset($error_msg)}
				<div>{$error_msg}</div>
			{/if}
			{if isset($not_approved_msg)}
				<div>{$not_approved_msg.msg}</div>
			{/if} 
		</div>
		<input type="text" id ="username" class="check validate[required]" name="username" value="{$entered_username|default:"نام کاربری"}"/>
		<input type="text" id="password" class="pass check validate[required]" name="password" value="رمز عبور"/>
		<input type="submit" id="last" class="submit_btm" name="submit" value="ورود"/><br/>
		<div id="register_msg">اگر تاکنون در سایت ثبت نام ننموده‌اید از اینجا ثبت نام کنید<br/>
			<a href= "{$base_url}user/signup" id="register_btm">ثبت نام در سایت</a>
		</div>
	</form>
</div>
{/block}