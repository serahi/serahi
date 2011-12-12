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

{if count($transactions) > 0}
<br/>
لیست تراکنش ها
<br/>
<table>
    <thead>
        <tr>
            <th>نام محصول</th>
            <th> شناسه محصول</th>
            <th> تعداد</th>
            <th>زمان</th>
            <th>کد رهگیری</th>
        </tr>
    </thead>
    <tbody>
        {foreach $transactions as $transaction}
        <tr>
            <td><a href={$base_url}product/view?id={$transaction.product_id}>{$transaction.product_name}</a></td>
            <td>{$transaction.product_id}</td>
            <td>{$transaction.count}</td>
            <td>{$transaction.transaction_time}</td>
            <td>{$transaction.pursuit_code}</td>
            <td>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}
{/block}
