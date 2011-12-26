{block name=css}
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/tables.css" />
{/block}

{block name=script}
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/amin.js"></script>
<script language="javascript">
	$(document).ready(function() {
		$("tr:nth-child(odd)").addClass("odd");
		$(".farsi_date").each(function(){
			var parts = $(this).text().split(' ');
			var date = jd_to_persian(parseInt(parts[0]));
			$(this).text(date[0] + '/' + date[1] + '/' + date[2] + ' ' + parts[1]);
		});
	});

</script>
{/block}
{block name=main_content}
<a href = "<?php echo base_url();?>admin/product_form">افزودن محصول جدید</a>

{if count($sellers) > 0}
<br/>
<div style="text-align:center">
لیست فروشنده های تایید نشده
</div>
<br/>
<table>
    <thead>
        <tr>
            <th><a href="<?php echo base_url();?>admin/?sort_by=fName">نام فروشنده</a></th>
            <th><a href="<?php echo base_url();?>admin/?sort_by=fLastName">نام خانوادگی فروشنده</a></th>
            <th><a href="<?php echo base_url();?>admin/?sort_by=fNumber">شماره تلفن</a></th>
        </tr>
    </thead>
    <tbody>
        {foreach $sellers as $seller}
        <tr>
            <td>{$seller.first_name}</td>
            <td>{$seller.last_name}</td>
            <td>{$seller.phone}</td>
            <td>
            	<form method="post" action="<?php echo base_url(); ?>admin/approving_seller">
                    <input type="hidden" value="{$seller.id}" name="seller_id"/>
                    <input type="submit" value="تایید" />
                </form>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}
<br />
<div style="text-align:center">
لیست محصولات فعلی
</div>
<br>
<table>
	<thead>
		<tr>
			<th>نام محصول</th>
			<th>قیمت</th>
			<th>تخفیف</th>
			<th>حدنصاب فروش</th>
			<th>نام فروشنده</th>
			<th>زمان آغاز</th>
			<th>مدت زمان نمایش</th>
			<th>عملیات</th>
		</tr>
	</thead>
	<tbody>
	{foreach $products as $product}
		<tr>
			<td>{$product.product_name}</td>
			<td>{$product.price}</td>
			<td>{$product.base_discount}</td>
			<td>{$product.lower_limit}</td>
			<td>{$product.display_name}</td>
			<td class = "farsi_date">{$product.start_schedule} {$product.start_time}</td>
			<td>{$product.duration}</td>
			<td><a href = "<?php echo base_url();?>admin/edit_product?id={$product.id}"> ویرایش </a>
			<form class = "table_form" method = "post" action = "<?php echo base_url();?>admin/delete_product">
				<input name = "id" value = "{$product.id}" type = "hidden">
				<input type = "submit" value = "حذف">
			</form></td>
		</tr>
	{/foreach}
	</tbody>
</table>
{/block}
