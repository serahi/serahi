{block name=title}ویرایش اطلاعات کاربری{/block}
{block name=css}
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/admin.css" />
{/block}
{block name=script}
<script type="text/javascript">
{literal}
	$(document).ready(function(){
		$(".submit_form").validationEngine({
			'validationEventTrigger' : 'submit',
			'promptPosition' : 'topLeft'
		});
	});
{/literal}
</script>
{/block}
{block name=main_content}
{assign var=int value='required,custom[integer],min[0]'}
{assign var=required value='validate[required]'}
{assign var=required_3 value='validate[minSize[3]]'}
{assign var=required_6 value='validate[minSize[6]]'}
<form method = "post" class = "submit_form" action = "<?php echo base_url() . "admin/userlist/save_edit";?>">
	
	<div class = "row">
		<label>شماره:</label>
		<div id = "user_id">
			{$id}
		</div>
	</div>
	<?php echo validation_errors('<div class="error_msg">', '</div>'); ?>
	<input type = "hidden" name = "id" value = "{$id}">
	<label for = "username">نام کاربری</label>
	<input name = "username" id = "username" class = "{$required_6}" value = "{$username}">
	<label for = "password">رمز عبور جدید</label>
	<input name = "password" id = "password" class = "{$required_6}" value = "" type = "password">
	<label for = "first_name">نام</label>
	<input name = "first_name" id = "first_name" class = "{$required_3}" value = "{$first_name}">
	<label for = "last_name">نام خانوادگی</label>
	<input name = "last_name" id = "last_name" class = "{$required_3}" value = "{$last_name}">
	<label for = "user_type">نوع کاربر</label>
	<input name = "user_type" value = "{$user_type}">
	<label for = "email">پست الکترونیکی</label>
	<input name = "email" id = "email" class = "validate[custom[email]]" value = "{$email}">
	{if $user_type eq 'seller'}
		<label for = "display_name">نام فروشگاه</label>
		<input name = "display_name" id = "display_name" class = "{$required}" value = "{$display_name}">
		<label for = "address">آدرس</label>
		<input name = "address" id = "address" value = "{$address}" class = "{$required}">
		<label for = "phone">تلفن</label>
		<input name = "phone" id = "phone" class = "validate[custom[phone]]" value = "{$phone}">
		<div class = "row">
		{if $approved eq 'TRUE'}
			<input type = "checkbox" name = "approved" id = "approved" checked = "checked">
		{else}
			<input type = "checkbox" name = "approved" id = "approved">
		{/if}
		<label for = "approved">تایید شده</label>
		</div>
	{elseif $user_type eq 'customer'}
		<label for = "address">آدرس</label>
		<input name = "address" id = "address" class = "{$required}"value = "{$address}">
		<label for = "postal_code">کد پستی</label>
		<input name = "postal_code" id = "postal_code" class = "{$int}" value = "{$postal_code}">
		<label for = "phone">تلفن</label>
		<input name = "phone" id = "phone" class = "validate[custom[phone]]" value = "{$phone}">
	{/if}
	<div class = "row">
		<label>زمان ایجاد حساب:</label>
		<div id = "creation_time">
			{$creation_time}
		</div>
	</div>
	<input type = "submit" value = "ثبت تغییرات">
</form>
{/block}