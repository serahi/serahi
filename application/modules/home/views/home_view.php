{block name=title}
سه‌راهـــــی
{/block}
{block name=script}
<script>
    
</script>
{/block}

{block name=main_content}
{if isset($products)}
<div class="product">
	{foreach from=$products item=item name=props}
	<div class="item">
            <script>
                $remaing_minutes = {$item.remaining} / 60;
                $(document).ready(function(){
                    $('#remain_time').value("mmm");
                });
                
            </script>
            <div class="remaining">
                <b>
                    زمان باقیمانده برای خرید این کالا
                </b>
                <div id="">
                    <input id="remain_time" value="ss" >
                </div>
                
            </div>
		<div class="item_pic">
			<img src="<?php echo base_url();?>images/products/{$item.image}" />
		</div>
		<div class="item_name">
			<b> نام کالا: </b>{$item.product_name}
		</div>
		<div class="item_price">
			<b>  قیمت کالا: </b>{$item.price} تومان
		</div>
		<div class="base_discount">
			<b> تخفیف پایه: </b>{$item.base_discount} درصد
		</div>
		<div class="lower_limit">
			<b> حد نصاب: </b>{$item.lower_limit}
		</div>
		<div class="sell_count">
			<b> تعداد فروخته شده تا الان: </b>{$item.sell_count}
		</div>
                وضعیت فروش
                <progress value="{$item.sell_count}" max="{$item.lower_limit}"></progress>
                <div class="progress value">
                    {$item.sell_count}/{$item.lower_limit}
                </div>
		<div class="description">
			<pre>{$item.description}</pre>
		</div>
		<div class="buy">
			{if $item.buying_state eq 0}
			<form method="post"   action="<?php echo base_url() .'home/buy';?>" class="forms">
				<input type="submit" value="خرید">
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
			{elseif $item.buying_state eq 2}
			<form method="post" action="<?php echo base_url() . 'home/buy'?>" class="forms buy_form" name="buying_form{$smarty.foreach.props.index}">
				<input type="submit" class="bconfirm" value="خرید"  >
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
			{elseif $item.buying_state eq 1}
			<div class="not_found_item">
				این کالا قبلاً توسط شما خریداری شده است!
			</div>
<!--			<div class="pursuit_code">
				کدرهگیری شما: {$item.pursuit_code}
			</div>
                        {if $item.sell_count < $item.lower_limit}
			<form method="post" action="<?php echo base_url() . 'home/cancel_transaction'?>" class="forms cancel_buying" >
				<input type="submit" value="لغو خرید">
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
                        {/if}
			{elseif $item.buying_state eq 3}
			<div class="not_found_item">این کالا قبلاً توسط شما خریداری شده است!</div> 
<!--			<div class="pursuit_code">
				کدرهگیری شما: {$item.pursuit_code}
			</div>-->
			{/if}
		</div>
	</div>
	{/foreach}
</div>
{elseif $this->session->userdata('is_logged_in')}
	کالایی یافت نشد
{/if}
{/block}