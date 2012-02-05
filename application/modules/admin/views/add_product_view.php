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
	$("#start_decoy").val($("start_schedule").val());
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
		<?php echo validation_errors('<div class="error_msg">', '</div>');?>
		<?php t_input('product_name', 'class:{$required}');?>
		<?php t_input('product_price', 'class:validate[{$int}]');?>
		<?php t_input('base_discount', 'class:validate[{$int}, max[100]]');?>
		<?php t_input('lower_limit', 'class:validate[{$int}]');?>
		<?php t_label('file');?>
		<input type="file" name="userfile" size="18" />
		<?php t_select('seller', $sellers, 'class:{$required}|null', 'id', 'display_name');?>
		<div class = "hrow">
			<?php t_label('start_schedule');?>
			<?php t_label('start_time');?>
			<?php t_label('duration');?>
		</div>
		<div class = "hrow">
			<div class = "dblock">
				<?php t_input('start_schedule', 'hidden');?>
				<input name = "start_decoy" id = "start_decoy" class = "date" disabled = "disabled">
				<button type = "button" onclick = "displayDatePicker('start_schedule', this);" >انتخاب</button>
			</div>
			<div class = "dblock">
				<select name = "start_time">
					{for $i=0; $i < 24; $i++}
						<option value = '{$i}:00' <?php echo set_select('start_time', '{$i}:00');?>>{$i}:00</option>
						<option value = '{$i}:30' <?php echo set_select('start_time', '{$i}:30');?>>{$i}:30</option>
					{/for}
				</select>
			</div>
			<div class = "dblock">
				<select name = "duration">
					{for $i=12; $i <= 48; $i = $i + 12}
						<option value = "{$i*3600}" <?php echo set_select('duration', '{$i*3600}');?>>{$i} ساعت</option>
					{/for}
				</select>
			</div>
		</div>
<!--		<textarea name = "product_desc" rows = "9" cols = "70"></textarea>
        -->

        <div id="editor_wrapper">
        		<?php t_label('product_desc');?>
            <textarea rows="1" style="display: block; visibility: hidden;" name="blank_text"> </textarea>

            <div id="ck_editor">
                    <textarea name="product_desc" id="content" >
                    <p></p>
                    </textarea>
                    <?php echo display_ckeditor($ck_config['ckeditor']); ?>
            </div>
        </div>
		<input type="submit" value="اضافه کردن محصول" name="submit">
	</form>
</div>

{/block} 