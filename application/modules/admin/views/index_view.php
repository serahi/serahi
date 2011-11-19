{block name=main_content}
<a href = "<?php echo base_url();?>admin/product_form">افزودن محصول جدید</a>
<br />
لیست محصولات فعلی
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
			<td>{$product.start_schedule} {$product.start_time}</td>
			<td>{$product.duration}</td>
			<td>delete or edit</td>
		</tr>
	{/foreach}
	</tbody>
</table>
{/block}
