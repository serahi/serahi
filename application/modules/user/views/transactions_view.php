{block name=css}
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/style/admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/style/tables.css" />
{/block}

{block name=script}
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/amin.js"></script>
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
<div style="text-align:center">
لیست تراکنش ها
</div>
<br/>
<table>
    <thead>
        <tr>
            <th>زمان</th>
            <th>نام محصول</th>
            <th>قیمت</th>
            <th>تخفیف</th>
            <th>وضعیت</th>
            <th>کد رهگیری</th>
        </tr>
    </thead>
    <tbody>
        {foreach $transactions as $transaction}
        <tr>
            <td>{$transaction.transaction_time}</td>
            <td><a href={$base_url}product/view?id={$transaction.product_id}>{$transaction.product_name}</a></td>
            <td>{$transaction.price}</td>
            <td>{$transaction.base_discount}%</td>
            <td>{if $transaction.status=="ready"}آماده{else if $transaction.status=="delivered"}تحویل شده{else}به حد نصاب نرسیده{/if}</td>
            <td>{$transaction.pursuit_code}</td>
        </tr>
        {/foreach}
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>مجموع خریدها</th>
            <th>مجموع تخفیف ها</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{$total_money}</td>
            <td>{$discount}</td>
        </tr>  
    </tbody>
</table>
{/if}
{/block}
