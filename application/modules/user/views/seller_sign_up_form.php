{block name=script}
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBr6OmZbDrrQqCSxyNGQz8NLxU7XHewT_k&sensor=false">
</script>
<script type="text/javascript">
	{literal}
	var marker = undefined;
	$(document).ready(function(){
		var myLatlng = new google.maps.LatLng(35.742, 51.506);
		var myOptions = {
		  zoom: 15,
		  center: myLatlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  disableDoubleClickZoom: true
		};
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		marker = new google.maps.Marker({map: map, position: myLatLng});
  	$("#map_location").val(map.getCenter().lat() + ' ' + map.getCenter().lng());
  	google.maps.event.addListener(map, 'dblclick', function(event) {
  		if (marker == undefined){
  			marker = new google.maps.Marker({map: map, position: event.latLng});
  		} else {
  			marker.setPosition(event.latLng);
  		}
  		map.setCenter(event.latLng);
  		$("#map_location").val(map.getCenter().lat() + ' ' + map.getCenter().lng());
  	});
  });
	{/literal}
</script>
{/block}

{block name=title}
فرم ثبت‌ نام فروشنده‌
{/block}
{block name=main_content}
<div id="sign_up_form">
	<?php

	echo validation_errors('<div class="error_msg">', '</div>');

	if (isset($user_not_unique))
		echo '<div class="error_msg">' . $user_not_unique . '</div>';
	?>
	<form action="{$base_url}user/register" class="forms submit_form" method="post">
		<input id="username" type="text"  class="check validate[required]" name="username" value="<?php echo set_value('username', 'نام کاربری');?>"/>
		<input id="password" type="text" class="check pass validate[required]" name="password" value="رمز عبور"/>
		<input id="c_password" type="text" class="check pass validate[required,equals[password]]" name="passconf" value="تکرار رمز عبور"/>
		<input id="first_name" type="text" class="check validate[required]" name="first_name" value="<?php echo set_value('first_name', 'نام');?>"/>
		<input id="last_name" type="text" class="check validate[required]" name="last_name" value="<?php echo set_value('last_name', 'نام خانوادگی');?>"/>
		<input id="email" type="text" class="check validate[required,custom[email]]" name="email" value="<?php echo set_value('email', 'آدرس پست‌الکترونیکی' );?>"/>
		<input id="phone" type="text" class="check validate[required]" name="phone" value="شماره‌ی تماس"/>
		<input id="address" type="text" class="check validate[required]" name="address" value="آدرس دقیق"/>
		<div style="height:275px">
		<div id="map_canvas" style="width: 100%; height: 100%"></div>
		</div>
    <input id="map_location" type="hidden" name="map_location"/>
    <input id="seller_display_name" type="text" class="check" name="seller_display_name" value="نام شرکت یا فروشگاه شما"/>
		<input type="hidden" value="s" name="ut">
		<div id="register_msg">لطفاً پیش از ثبت‌نام قوانین سایت را مطالعه بفرمایید.<br/>
			<a href="site/rules" id="register_btm">قوانین سایت</a><br/>
			<br/><input class="confirmation" type="checkbox" value="" name="confirmation">
			<label for="confirmation">قوانین سایت را مطالعه کرده و قبول می&zwnj;کنم</label>
		</div>
		<input id="reg_btm" class="submit_btm" type="submit" value="ثبت‌نام" name="submit">
	</form>
</div>
{/block}