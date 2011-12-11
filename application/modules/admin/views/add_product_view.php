{block name=title}پنل مدیر{/block}
{block name=css}
<link rel="stylesheet" type="text/css" href="{$base_url}assets/style/admin.css" />
<link rel="stylesheet" type="text/css" href="{$base_url}assets/style/calendar.css" />
{/block}

{block name=script}
<script type="text/javascript" src="{$base_url}assets/scripts/amin.js"></script>
<script type="text/javascript" src="{$base_url}assets/scripts/calendar.js"></script>
<script type = "text/javascript">
{literal}
function datePickerClosed (dateField) {
	if (dateField.name == "start_schedule") {
		document.getElementById('start_decoy').value = dateField.value;
	}
}
$(document).ready(function (){
	$("#product_form").submit(function () {
		if (isNaN($("#start_schedule").val())) {
			var date_str = $("#start_schedule").val();
			var vals = date_str.split("/");
			vals[1] = vals[1].replace(new RegExp("^[0]+", "g"), "");
			vals[2] = vals[2].replace(new RegExp("^[0]+", "g"), "");
			var jd = persian_to_jd(parseInt(vals[0]), parseInt(vals[1]), parseInt(vals[2]));
			$("#start_schedule").attr('value', jd);
		}
	});
});
{/literal}
</script>
{/block}
{block name=main_content}
<div id="add_product_form">
	<form id = "product_form" class = "submit_form product_form" enctype = "multipart/form-data" method = "post" action = "{$base_url}admin/add_product">
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
			{foreach $sellers as $seller}
				<option value="{$seller.id}">{$seller.display_name}</option>
			{/foreach}
		</select>
		<div class = "hrow">
			<label for = "start_schedule">تاریخ آغاز نمایش</label>
			<label for = "start_time">ساعت آغاز نمایش</label>
			<label for = "duration">مدت زمان نمایش</label>
		</div>
		<div class = "hrow">
			<div class = "dblock">
				<input name = "start_schedule" type="hidden" id = "start_schedule">
				<input name = "start_decoy" id = "start_decoy" class = "date" disabled = "disabled">
				<button type = "button" onclick = "displayDatePicker('start_schedule', this);" >انتخاب</button>
			</div>
			<div class = "dblock">
				<select name = "start_time">
					{for $i=0; $i < 24; $i++}
						<option value = '{$i}:00'>{$i}:00</option>
						<option value = '{$i}:30'>{$i}:30</option>
					{/for}
				</select>
			</div>
			<div class = "dblock">
				<select name = "duration">
					{for $i=12; $i <= 48; $i = $i + 12}
						<option value = "{$i*3600}">{$i} ساعت</option>
					{/for}
				</select>
			</div>
		</div>
		<label for = "product_desc">شرح محصول</label>
		<textarea name = "product_desc" rows = "9" cols = "70"><?php echo set_value('product_desc');?></textarea>
		<input type="submit" value="اضافه کردن محصول" name="submit">
	</form>
</div>
{/block} 