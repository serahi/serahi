{block name=title}
پنل فروشنده
{/block}

{block name=script}
<script type="text/javascript" src="{$base_url}assets/scripts/jquery.sparkline.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.timeline_graph').sparkline('html');
	});
</script>
{/block}

{block name=main_content}
{if isset($products) && count($products) > 0}
	<div class="product">
	{foreach $products as $product}
		<div class="seller_item" style="padding:1em;border:2px solid gray;">
			<div class="item_name">
				<b> نام کالا: </b>{$product.product_name}
			</div>
			<div class="lower_limit">
				<b> حد نصاب: </b>{$product.lower_limit}
			</div>
			<div>
				وضعیت محصول: {$product.state}
			</div>
			<div class="sell_count">
				<b> تعداد سفارش شده: </b>{$product.sell_count}
			</div>
			{if $product.delivered_count > 0}
			<div class="delivered_count">
				<b> تعداد تحویل شده: </b>{$product.delivered_count}
			</div>
			{/if}
			<div class = "timeline_container">
				نمودار تعداد سفارش محصول بر حسب زمان:
				<span class = "timeline_graph" values = '{$product.timeline}'></span>
			</div>
		</div>
	{/foreach}
	</div>
{else}
	کالایی یافت نشد.
{/if}
{/block}