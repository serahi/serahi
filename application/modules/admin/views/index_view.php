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
            <th><a href="<?php echo base_url();
            if(isset($_GET['seller_sort_by']) && $_GET['seller_sort_by'] == 'fName' && $_GET['seller_type'] == 'asc')
            {
                echo "admin/?seller_sort_by=fName&seller_type=desc";
            }
            else
                echo "admin/?seller_sort_by=fName&seller_type=asc";?>">نام فروشنده</a></th>
            
            <th><a href="<?php echo base_url();
            if(isset($_GET['seller_sort_by']) && $_GET['seller_sort_by'] == 'fLastName' && $_GET['seller_type'] == 'asc')
            {
                echo "admin/?seller_sort_by=fLastName&seller_type=desc";
            }
            else 
                echo "admin/?seller_sort_by=fLastName&seller_type=asc";?>"<a>نام خانوادگی فروشنده</a></th>
            
            <th><a href="<?php echo base_url();
            if(isset($_GET['seller_sort_by']) && $_GET['seller_sort_by'] == 'fNumber' && $_GET['seller_type'] == 'asc')
            {
                echo "admin/?seller_sort_by=fNumber&seller_type=desc";
            }
            else 
                echo "admin/?seller_sort_by=fNumber&seller_type=asc";?>">شماره تلفن</a></th>
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
			<th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pName' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pName&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pName&product_type=asc";?>">نام محصول</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pPrice' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pPrice&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pPrice&product_type=asc";?>">قیمت</a></th>
			<th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pDiscount' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pDiscount&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pDiscount&product_type=asc";?>"/>تخفیف</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pLimit' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pLimit&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pLimit&product_type=asc";?>"/>حدنصاب فروش</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pSname' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pSname&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pSname&product_type=asc";?>"/>نام فروشنده</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pStime' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pStime&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pStime&product_type=asc";?>"/>زمان آغاز</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['product_sort_by']) && $_GET['product_sort_by'] == 'pDtime' && $_GET['product_type'] == 'asc')
                        {
                            echo "admin/?product_sort_by=pDtime&product_type=desc";
                        }
                        else
                            echo "admin/?product_sort_by=pDtime&product_type=asc";?>"/>مدت زمان نمایش</a></th>
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
