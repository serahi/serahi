{block name=title}
فرم ثبت‌ نام مشتریان قسمت دوم‌
{/block}

{block name=main_content}
<div id="sign_up_form">
	<?php
	//echo validation_errors('<div class="error_msg">', '</div>');
	?>
	<form class="forms submit_form" action="{$base_url}user/complete_registration" method="post">
		<input id="phone" type="text" class="check" name="phone" value="<?php echo set_value('tel', 'شماره‌ی تماس');?>"/>
		<input id="postal_code" type="text" class="check" name="postal_code" value="<?php echo set_value('postal_code', 'کد پستی');?>"/>
		<input id="address" type="text" class="check" name="address" value="<?php echo  set_value('address', 'آدرس');?>"/>
		<input type="hidden" value="{$user_id}" name="user_id">
		<input id="reg2_btm" class="submit_btm" type="submit" value="ارسال" name="submit">
		<input id="skip_btm" class="submit_btm" type="submit" value="گذر" name="submit">
	</form>
</div>
{/block}