{block name=script}
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBr6OmZbDrrQqCSxyNGQz8NLxU7XHewT_k&sensor=false">
</script>
<script type="text/javascript">
	<?php list($map_lat, $map_lng) = explode(' ', $product['map_location']);
	      echo "var lat = $map_lat;";
				echo "var lang = $map_lng;";
	?>
	var marker_title = '{$seller_display_name|default:''}';
	{literal}
	$(document).ready(function(){
		var myLatlng = new google.maps.LatLng(lat, lang);
		var myOptions = {
		  zoom: 15,
		  center: myLatlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var g_map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		var marker = new google.maps.Marker({position: myLatlng, map: g_map, title: marker_title});
  });
	{/literal}
</script>
{/block}

{block name=title}
سه‌راهـــــی
{/block}

{block name=main_content}
<div class="product">
	<div class="item">
		<script>
			var remaining = {$product['remaining']};
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
		<div class = "item_title"><a href = "{$base_url}product/view?id={$product['id']}">{$product['product_name']}</a></div>
		<div class="remaining">
		    <b>
		        زمان باقیمانده برای خرید این کالا
		    </b>
		    <div id = "remain_hidden" style="display:none">
		    	{$product['remaining']}
		    </div>
		    <div id="remain_time">
		    </div>
		</div>
		<div class="item_pic">
			<img src="{$base_url}images/products/{$product['image']}" />
		</div>
		<div class="item_name">
			<b> نام کالا: </b>{$product['product_name']}
		</div>
		<div class="item_price">
			<b>  قیمت کالا: </b>{$product['price']} تومان
		</div>
		<div class="base_discount">
			<b> تخفیف پایه: </b>{$product['base_discount']} درصد
		</div>
		<div class="lower_limit">
			<b> حد نصاب: </b>{$product['lower_limit']}
		</div>
		<div class="sell_count">
			<b> تعداد فروخته شده تا الان: </b>{$product['sell_count']}
		</div>
    وضعیت فروش
    <progress value="{$product['sell_count']}" max="{$product['lower_limit']}"></progress>
    <div class="progress value">
        {$product['sell_count']}/{$product['lower_limit']}
    </div>
		<div class="description" >
			<pre>{$product['description']}</pre>
		</div>
		<div style="height:275px;width:275px; margin: 0 auto;">
			<div id="map_canvas" style="width: 100%; height: 100%"></div>
		</div>
		<div class="buy">
			{if $product['buying_state'] eq 0}
			<form method="post"   action="{$base_url}home/buy" class="forms">
				<input type="submit" value="خرید">
				<input type="hidden" value="{$product['id']}" name="product_id">
			</form>
			{elseif $product['buying_state'] eq 2}
			<form method="post" action="{$base_url}home/buy" class="forms buy_form" name="buying_form">
				<input type="submit" class="bconfirm" value="خرید">
				<input type="hidden" value="{$product['id']}" name="product_id">
			</form>
			{elseif $product['buying_state'] eq 1}
			<div class="not_found_item">
				این کالا قبلاً توسط شما خریداری شده است!
			</div>
			{if $product['sell_count'] < $product['lower_limit']}
			<form method="post" action="{$base_url}home/cancel_transaction" class="forms cancel_buying" >
				<input type="submit" value="لغو خرید">
				<input type="hidden" value="{$product['id']}" name="product_id">
			</form>
			{/if}
			{elseif $product['item.buying_state'] eq 3}
			<div class="not_found_item">این کالا قبلاً توسط شما خریداری شده است!</div> 
			{/if}
		</div>
	</div>
    <?php if (isset($comments) && count($comments)>0):?>
    <?php foreach ($comments as $comment): ?>
            <div class="item">
                
                <form id="edit" method="post" action="{$base_url}product/product/edit_comment" class="forms" >
                    <!--<input type="hidden" value="{$comment['id']}" name="comment_id">-->
                    <input type="hidden" value="{$product['id']}" name="product_id">
                    <input type="submit" name="e" value="ویرایش" />
                </form>
                <form id="delete" method="post" action="{$base_url}product/product/remove_comment" class="forms" >
                    
                    <!--<input type="hidden" value="{$comment['id']}" name="comment_id">-->
                    <input type="hidden" value="{$product['id']}" name="product_id">
                    <input type="submit" name="d" value="حذف" />
                </form> 
                <div class="item_title"> <b> <?php echo $comment['username']; ?> </b> </div>
                <div class="news_date"> <?php echo $comment['date']; ?> </div>
                <div class="desc"> <?php echo $comment['content']; ?> </div>
           
            </div>
        <?php endforeach; ?>
    <?php endif;?>
        <?php echo $this->pagination->create_links(); ?>
</div>

<div id="sign_up_form">
<form id="add" method="post" action="{$base_url}product/product/add_comment" class="forms" >
    <textarea cols="30" rows="10" type="text" id="comment_content" class="check" name="comment_content" value=""  title=""></textarea>
    <input type="hidden" value="{$product['id']}" name="product_id">
    <input type="submit" name="a" value="ثبت نظر" />
        
</form>
</div>

{/block}