{block name=title}
پنل فروشنده
{/block}

{block name=main_content}
{if isset($products) && count($products) > 0}
	<div class="product">
	{foreach $products as $product}
		<div class="item">
			<div class="item_name">
				<b> نام کالا: </b>{$product.product_name}
			</div>
			<div class="lower_limit">
				<b> حد نصاب: </b>{$product.lower_limit}
			</div>
			<div class="sell_count">
				<b> تعداد فروخته شده: </b>{$product.sell_count}
			</div>
		</div>
	{/foreach}
	</div>
{else}
	echo "کالایی یافت نشد";
{/if}
{/block}