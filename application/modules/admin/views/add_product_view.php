{block name=title}پنل مدیر{/block}
{block name=css}
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/admin.css" />
{/block}

{block name=script}
<script type = "text/javascript">
{literal}
function datePickerClosed (dateField) {
	if (dateField.name == "start_schedule") {
		document.getElementById('start_decoy').value = dateField.value;
	}
}
{/literal}
</script>
{/block}
{block name=main_content}
{assign var=int value='required,custom[integer],min[0]'}
{assign var=required value='validate[required]'}
<div id="add_product_form">
	<form class = "submit_form product_form" enctype = "multipart/form-data" method = "post" action = "<?php echo base_url() . 'admin/add_product';?>">
		<?php  echo validation_errors('<div class="error_msg">', '</div>');?>
		<label for = "product_name">نام محصول</label>
		<input name = "product_name" id = "product_name" class = "{$required}" value = "<?php echo set_value('product_name');?>">
		<label for = "product_price">قیمت واقعی</label>
		<input name = "product_price" id = "product_price" class = "validate[{$int}]" value = "<?php echo set_value('product_price');?>">
		<label for = "base_discount">تخفیف پایه</label>
		<input name = "base_discount" id = "base_discount" class = "validate[{$int},max[100]]" value = "<?php echo set_value('base_discount');?>">
		<label for = "lower_limit">حد نصاب</label>
		<input name = "lower_limit" id = "lower_limit" class = "validate[{$int}]" value = "<?php echo set_value('lower_limit');?>">
		<label for = "file">انتخاب تصویر</label>
		<input type="file" name="userfile" size="18" />
		<label for = "seller">فروشنده</label>
		<select name = "seller" id = "seller" class="{$required}">
			<option value = ''>انتخاب نمایید</option>
			<?php
			foreach ($sellers as $seller) {
				echo '<option value="' . $seller['id'] . '">' . $seller['display_name'] . '</option>';
			}
			?>
		</select>
		<div class = "hrow">
			<label for = "start_schedule">تاریخ آغاز نمایش</label>
			<label for = "start_time">ساعت آغاز نمایش</label>
			<label for = "duration">مدت زمان نمایش</label>
		</div>
		<div class = "hrow">
			<div class = "dblock">
				<input name = "start_schedule" type="hidden">
				<input name = "start_decoy" id = "start_decoy" class = "date" disabled = "disabled">
				<button type = "button" onclick = "displayDatePicker('start_schedule', this);" >انتخاب</button>
			</div>
			<div class = "dblock">
				<select name = "start_time">
					<?php for ($i=0; $i < 24; $i++) {
						echo "<option value = '$i:00'>$i:00</option>";
						echo "<option value = '$i:30'>$i:30</option>";
					}?>
				</select>
			</div>
			<div class = "dblock">
				<select name = "duration">
					<?php for ($i=12; $i <= 48; $i+=12) {
						echo "<option value = '".($i*3600)."'>$i ساعت</option>";
					}?>
				</select>
			</div>
		</div>
		<label for = "product_desc">شرح محصول</label>
		<textarea name = "product_desc" rows = "9" cols = "80"><?php echo set_value('product_desc');?></textarea>
		<input type="submit" value="اضافه کردن محصول" name="submit">
	</form>
</div>
{/block} 