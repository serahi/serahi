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
	var str = $('#start_decoy').val();
	var date = jd_to_persian(parseInt(str));
	$("#start_decoy").val(date[0] + '/' + date[1] + '/' + date[2]);
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
	<form id = "product_form" class = "submit_form product_form" enctype = "multipart/form-data" method = "post" action = "{$base_url}admin/save_product">
		<?php  echo validation_errors('<div class="error_msg">', '</div>');?>
		<input name = "id" type = "hidden" value = "{$id}">
		<?php t_input('product_name', 'class:{$required}');?>
		<?php t_input('product_price', 'class:validate[{$int}]');?>
		<?php t_input('base_discount', 'class:validate[{$int}, max[100]]');?>
		<?php t_input('lower_limit', 'class:validate[{$int}]');?>
		<?php t_label('file');?>
		<input type="file" name="userfile" size="18" />
		<?php t_select('seller', $sellers, 'class:{$required}|null|default:{$seller_id}', 'id', 'display_name');?>
		<div class = "hrow">
			<?php t_label('start_schedule');?>
			<?php t_label('start_time');?>
			<?php t_label('duration');?>
		</div>
		<div class = "hrow">
			<div class = "dblock">
				<?php t_input('start_schedule', 'hidden');?>
				<input name = "start_schedule" type="hidden" id = "start_schedule" value = "">
				<input name = "start_decoy" id = "start_decoy" class = "date" disabled = "disabled" value = "{$start_schedule}">
				<button type = "button" onclick = "displayDatePicker('start_schedule', this);" >انتخاب</button>
			</div>
			<div class = "dblock">
				<select name = "start_time">
					<?php for ($i=0; $i < 24; $i++) {
						echo "<option value = '$i:00'";
						if (ends_with($start_time, "$i:00:00"))
							echo set_select('start_time', '{$i}:00', TRUE);
						else 
							echo set_select('start_time', '{$i}:00');
						echo ">$i:00</option>";
						echo "<option value = '$i:30'";
						if (ends_with($start_time, "$i:30:00"))
							echo set_select('start_time', '{$i}:30', TRUE);
						else 
							echo set_select('start_time', '{$i}:30');
						echo ">$i:30</option>";
					}?>
				</select>
			</div>
			<div class = "dblock">
				<select name = "duration">
					{for $i=12; $i <= 48; $i = $i + 12}
						<option value = "{$i*3600}" {if $i * 3600 == $duration}
							<?php echo set_select('duration', '{$i*3600}', TRUE);?>
						{else}
							<?php echo set_select('duration', '{$i*3600}');?>
						{/if} >{$i} ساعت</option>
					{/for}
				</select>
			</div>
		</div>
		<label for = "product_desc">شرح محصول</label>
		<textarea name = "product_desc" rows = "9" cols = "80"><?php echo set_value('product_desc', $description);?></textarea>
		<input type="submit" value="اضافه کردن محصول" name="submit">
	</form>
</div>
{/block} 