{block name=title}
ورود به سیستم‌
{/block}

{block name=main_content}
{assign var=int value='required,custom[integer],min[0]'}
{assign var=required value='validate[required]'}
<div id="login_form">
	<form action="<?php echo base_url()?>user/login_check" class="forms submit_form" method="post">
	<div class='error_msg'>
		<?php
		if (isset($error_msg)) {
			echo "<div> $error_msg </div>";
		}
                if (isset ($not_approved_msg))
                {
                    echo '<div>' . $not_approved_msg['msg'] . '</div>';
                }
		?>
            
	</div>
	<?php if (!isset($entered_username)) { ?>
		<input type="text" id="username" class="check validate[required]" name="username" value="نام کاربری">
	<?php } else { ?>
		<input type="text" id ="username" class="check validate[required]" name="username" value="<?php echo $entered_username; ?>"/>
	<?php } ?>
	<input type="text" id="password" class="pass check validate[required]" name="password" value="رمز عبور"/>
	<input type="submit" id="last" class="submit_btm" name="submit" value="ورود"/><br/>
	<div id="register_msg">اگر تاکنون در سایت ثبت نام ننموده‌اید از اینجا ثبت نام کنید<br/>
		<a href= "<?php echo base_url();?>user/signup" id="register_btm">ثبت نام در سایت</a>
	</div>
	</form>
</div>
{/block}