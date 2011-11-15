{block name=title}پنل مدیر{/block}
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
<div id="add_product_form">
	<form class = "submit_form product_form" enctype = "multipart/form-data" method = "post" action = "<?php echo base_url() . 'admin/add_product';?>">
		<?php  echo validation_errors('<div class="error_msg">', '</div>');?>
		<label for = "product_name">نام محصول</label>
		<input name = "product_name" id = "product_name" class = "validate[required]" value = "<?php echo set_value('product_name');?>">
		<label for = "product_price">قیمت واقعی</label>
		<input name = "product_price" id = "product_price" class = "validate[required]" value = "<?php echo set_value('product_price');?>">
		<label for = "base_discount">تخفیف پایه</label>
		<input name = "base_discount" id = "base_discount" class = "validate[required,custom[integer],min[0],max[100]]" value = "<?php echo set_value('base_discount');?>">
		<label for = "lower_limit">حد نصاب</label>
		<input name = "lower_limit" id = "lower_limit" class = "validate[required,min[0]]" value = "<?php echo set_value('lower_limit');?>">
		<label for = "file">انتخاب تصویر</label>
		<input type="file" name="userfile" size="18" />
		<label for = "seller">فروشنده</label>
		<select name = "seller">
			<?php
			foreach ($sellers as $seller) {
				echo '<option value="' . $seller['id'] . '">' . $seller['display_name'] . '</option>';
			}
			?>
		</select>
		<label for = "product_desc">شرح محصول</label>
		<textarea name = "product_desc" rows = "9" cols = "80"><?php echo set_value('product_desc');?></textarea>
		<input type="submit" value="اضافه کردن محصول" name="submit">
	</form>
</div>
{/block} 