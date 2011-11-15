{block name=title}ویرایش اطلاعات کاربری{/block}
{block name=css}
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/admin.css" />
{/block}
{block name=main_content}
<form method = "post" class = "submit_form" action = "<?php echo base_url() . "admin/userlist/save_edit";?>">
	<div class = "row">
		<label>شماره:</label>
		<div id = "user_id">
			{$id}
		</div>
	</div>
	<input type = "hidden" name = "id" value = "{$id}">
	<label for = "username">نام کاربری</label>
	<input name = "username" value = "{$username}">
	<label for = "password">رمز عبور جدید</label>
	<input name = "password" value = "" type = "password">
	<label for = "first_name">نام</label>
	<input name = "first_name" value = "{$first_name}">
	<label for = "last_name">نام خانوادگی</label>
	<input name = "last_name" value = "{$last_name}">
	<label for = "user_type">نوع کاربر</label>
	<input name = "user_type" value = "{$user_type}">
	<label for = "email">پست الکترونیکی</label>
	<input name = "email" value = "{$email}">
	{if $user_type eq 'seller'}
		<label for = "display_name">نام فروشگاه</label>
		<input name = "display_name" value = "{$display_name}">
		<label for = "address">آدرس</label>
		<input name = "address" value = "{$address}">
		<label for = "phone">تلفن</label>
		<input name = "phone" value = "{$phone}">
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
		<input name = "address" value = "{$address}">
		<label for = "postal_code">کد پستی</label>
		<input name = "postal_code" value = "{$postal_code}">
		<label for = "phone">تلفن</label>
		<input name = "phone" value = "{$phone}">
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