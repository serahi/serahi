{block name=title}
ورود به سیستم‌
{/block}

{block name=main_content}
<div id="login_form">
	<form action="<?php echo base_url()?>user/login/login_check" class="forms" method="post">
	<div class='error_msg'>
		<?php
		if (isset($error_msg)) {
			echo "<div> $error_msg </div>";
		}
		?>
	</div>
	<?php if (!isset($entered_username)) { ?>
		<input type="text" id="username" class="check validate[required]" name="username" value="نام کاربری">
	<?php } else { ?>
		<input type="text" id ="username" class="check validate[required]" name="username" value="<?php echo $entered_username; ?>"/>
	<?php } ?>
	<input type="text" id="password" class="pass check" name="password" value="رمز عبور"/>
	<input type="submit" name="submit" value="ورود"/><br/>
	<div id="register_msg">اگر تاکنون در سایت ثبت نام ننموده‌اید از اینجا ثبت نام کنید<br/>
		<a href=/"user/login/sign_up" id="register_btm">ثبت نام در سایت</a>
	</div>
	</form>
</div>
{/block}