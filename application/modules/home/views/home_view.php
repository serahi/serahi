{block name=title}
سه‌راهـــــی
{/block}

{block name=main_content}
{if isset($products) && count($products) > 0}
<div class="product_wrapper">
<div class="product">
	{foreach from=$products item=item name=props}
	<div class="item">
		<script>
			{counter assign=count}
			var remaining = {$item.remaining};
			var callback_{$count} = function () {
				var txt = $("#remain_hidden_{$count}").text();
				var num = parseInt(txt);
				var remaining = num - 1;
				if (remaining < 0) remaining = 0;
				$("#remain_hidden_{$count}").text(remaining);
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
		    	$("#remain_time_{$count}").text(result);
			};
			window.setInterval(callback_{$count}, 1000);
		</script>
                
                
                
		<div class = "item_title <?php  ?>">
                    <a href = "{$base_url}product/view?id={$item.id}">{$item.product_name}</a>
                </div>
		<div class="remaining">
		    <b>
		        زمان باقیمانده برای خرید این کالا
		    </b>
		    <div id = "remain_hidden_{$count}" style="display:none">
		    	{$item.remaining}
		    </div>
		    <div id="remain_time_{$count}" style="display: -moz-inline-block;">
                        <script>callback_{$count}()</script>
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
    
    <div class="">
        وضعیت فروش
        <div class="progressbar">  <progress value="{$item.sell_count}" max="{$item.lower_limit}"></progress> </div>
    </div>
    <div class="progress value">
        
    </div>
		<div class="buy">
			{if $item.buying_state eq 0}
			<form method="post"   action="{$base_url}home/buy" class="forms">
				<input type="submit" value="خرید">
				<input type="hidden" value="{$item.id}" name="product_id">
			</form>
			{elseif $item.buying_state eq 2}
			<form method="post" action="{$base_url}home/buy" class="forms buy_form" name="buying_form{$smarty.foreach.props.index}">
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
		<div>
			برای مشاهده‌ی شرح محصول و محل فروشگاه 
			<a href = "{$base_url}product/view?id={$item.id}">اینجا</a>
			را کلیک کنید.
		</div>
		<a href="https://twitter.com/share" class="twitter-share-button"
		   data-url="{$base_url}product/view?id={$item.id}" data-lang="en"
		   data-text="{$item.product_name} با {$item.base_discount} درصد تخفیف، فقط برای امروز @ {$base_url}product/view?id={$item.id}">Tweet</a>
  	<script>{literal}!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");{/literal}</script>
		<div class="g-plusone" data-href="{$base_url}product/view?id={$item.id}"></div>
		<iframe src="//www.facebook.com/plugins/like.php?href={$base_url}product/view?id={$item.id}&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>

	</div>
	{/foreach}
</div>
	<script type="text/javascript">
	{literal}
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	{/literal}
	</script>

        <?php echo $this->pagination->create_links(); ?>
{elseif $this->session->userdata('is_logged_in')}
	کالایی یافت نشد
{/if}

</div>

{/block}