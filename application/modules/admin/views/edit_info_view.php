{block name=title}ویرایش اطلاعات کاربری{/block}
{block name=css}
<link rel="stylesheet" type="text/css" href="{$base_url}assets/style/admin.css" />
{/block}
{block name=script}
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBr6OmZbDrrQqCSxyNGQz8NLxU7XHewT_k&sensor=false">
</script>
<script type="text/javascript">
		var lat = {$map_lat|default:35.742};
		var lang = {$map_lng|default:51.506};
    {literal}
    var marker = undefined;
    $(document).ready(function(){
      $(".submit_form").validationEngine({
          'validationEventTrigger' : 'submit',
          'promptPosition' : 'topLeft'
      });
      

			var myLatlng = new google.maps.LatLng(lat, lang);
			var myOptions = {
			  zoom: 15,
			  center: myLatlng,
			  mapTypeId: google.maps.MapTypeId.ROADMAP,
			  disableDoubleClickZoom: true
			};
			var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		{/literal}
		{if isset($map_lat)}
		{literal}
			marker = new google.maps.Marker({map: map, position: myLatlng});
		{/literal}
		{/if}
		{literal}
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
{block name=main_content}
{assign var=required_3 value='validate[minSize[3]]'}
{assign var=required_5 value='validate[minSize[5]]'}
{assign var=required_6 value='validate[minSize[6]]'}

<form method = "post" class = "submit_form" action = "{$base_url}admin/userlist/save_edit">
    <div class = "row">
        <label>شماره:</label>
        <div id = "user_id">
            {$id}
        </div>
    </div>
    <?php echo validation_errors('<div class="error_msg">', '</div>'); ?>
    <input type = "hidden" name = "id" value = "{$id}">
    <label for = "username">نام کاربری</label>
    <input name = "username" id = "username" class = "{$required_5}" value = "{$username}">
    <label for = "password">رمز عبور جدید</label>
    <input name = "password" id = "password" class = "" value = "" type = "password">
    <label for = "passconf">تکرار رمز جدید</label>
    <input name = "passconf" id = "passconf" class = "validate[equals[password]]" value = "" type = "password">
    <label for = "first_name">نام</label>
    <input name = "first_name" id = "first_name" class = "{$required_3}" value = "{$first_name}">
    <label for = "last_name">نام خانوادگی</label>
    <input name = "last_name" id = "last_name" class = "{$required_3}" value = "{$last_name}">
    <?php if ($this->session->userdata('user_type') == 'admin') { ?>
        <label for = "user_type">نوع کاربر</label>
        <input name = "user_type" value = "{$user_type}">
    <?php } ?>
    <?php if ($this->session->userdata('user_type') == 'seller') { ?>
        <input type="hidden" value="seller" name="user_type">
    <?php } else if ($this->session->userdata('user_type') == 'customer') { ?> 
        <input type="hidden" value="customer" name="user_type">
    <?php } ?> 
    <label for = "email">پست الکترونیکی</label>
    <input name = "email" id = "email" class = "validate[custom[email]]" value = "{$email}">
    {if $user_type eq 'seller'}
    <label for = "display_name">نام فروشگاه</label>
    <input name = "display_name" id = "display_name" class = "{$required}" value = "{$display_name}"> 
    <label for = "address">آدرس</label>
    <input name = "address" id = "address" value = "{$address}" class = "{$required}">
    <label for = "phone">تلفن</label>
    <input name = "phone" id = "phone" class = "validate[custom[phone]]" value = "{$phone}">
    برای تغییر موقعیت خود روی نقشه دوبار کلیک کنید.
    <div style="height:275px;width:250px;float:right;">
			<div id="map_canvas" style="width: 100%; height: 100%"></div>
		</div>
    <input id="map_location" type="hidden" name="map_location"/>
    <?php if ($this->session->userdata('user_type') == 'admin') { ?>
        <div class = "row">
            {if $approved eq 'TRUE'}
            <input type = "checkbox" name = "approved" id = "approved" checked = "checked">
            {else}
            <input type = "checkbox" name = "approved" id = "approved">
            {/if}
            <label for = "approved">تایید شده</label>
        </div>
    <?php } ?>
    {elseif $user_type eq 'customer'}
    <label for = "address">آدرس</label>
    <input name = "address" id = "address" class = "{$required}"value = "{$address}">
    <label for = "postal_code">کد پستی</label>
    <input name = "postal_code" id = "postal_code" class = "{$int}" value = "{$postal_code}">
    <label for = "phone">تلفن</label>
    <input name = "phone" id = "phone" class = "validate[custom[phone]]" value = "{$phone}">
    {/if}
    <div class = "row">
        <label>زمان ایجاد حساب:</label>
        <div id = "creation_time">
            {$creation_time}
        </div>
    </div>
    <input type = "submit" value = "ثبت تغییرات">
</form>
{/block}
