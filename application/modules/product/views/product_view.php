{block name=title}
سه‌راهـــــی
{/block}

{block name=main_content}
<div class="product">
	<div class="item">
		<script>
			var remaining = {$item.remaining};
			var callback = function () {
				var txt = $("#remain_hidden").text();
				var num = parseInt(txt);
				var remaining = num - 1;
				if (remaining < 0) remaining = 0;
				$("#remain_hidden").text(remaining);
		    	var mins = remaining / 60;
		    	var hours = mins / 60;
		    	var days = hours / 24;
		    	days = days - days % 1;
		    	hours = hours % 24 - hours % 1;
		    	mins = mins % 60 - mins % 1;
		    	var secs = remaining % 60;
		    	var result = '';
		    	if (days > 0) result = result + days + ' روز ';
		    	if (hours > 0)result = result + hours+ ' ساعت ';
		    	if (mins > 0) result = result + mins + ' دقیقه ';
		    	if (secs > 0) result = result + secs + ' ثانیه';
		    	$("#remain_time").text(result);
			};
			window.setInterval(callback, 1000);
		</script>
		<div class = "item_title"><a href = "{$base_url}product/view?id={$item.id}">{$item.product_name}</a></div>
		<div class="remaining">
		    <b>
		        زمان باقیمانده برای خرید این کالا
		    </b>
		    <div id = "remain_hidden" style="display:none">
		    	{$item.remaining}
		    </div>
		    <div id="remain_time">
		    </div>
		</div>
		<div class="item_pic">
			<img src="{$base_url}images/products/{$item.image}" />
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
			<form method="post"   action="{$base_url}home/buy" class="forms">
				<input type="submit" value="خرید">
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
			{elseif $item.buying_state eq 2}
			<form method="post" action="{$base_url}home/buy" class="forms buy_form" name="buying_form">
				<input type="submit" class="bconfirm" value="خرید">
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
			{elseif $item.buying_state eq 1}
			<div class="not_found_item">
				این کالا قبلاً توسط شما خریداری شده است!
			</div>
			{if $item.sell_count < $item.lower_limit}
			<form method="post" action="{$base_url}home/cancel_transaction" class="forms cancel_buying" >
				<input type="submit" value="لغو خرید">
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
			{/if}
			{elseif $item.buying_state eq 3}
			<div class="not_found_item">این کالا قبلاً توسط شما خریداری شده است!</div> 
			{/if}
		</div>
	</div>
</div>
{/block}