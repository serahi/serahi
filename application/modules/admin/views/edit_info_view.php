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

<form method = "post" class = "submit_form">
    <div class = "row">
        <label>شماره:</label>
        <div id = "user_id">
            {$id}
        </div>
    </div>
    <?php
	    echo validation_errors('<div class="error_msg">', '</div>');
	    t_input('id', 'hidden');
	    t_input('username', 'class:{$required_5}');
	    t_input('password', 't:new_password');
	    t_input('password_confirm', "class:validate[equals[password]]");
	    t_input('first_name', "class:{$required_3}");
	    t_input('last_name', "class:{$required_3}");
	    if ($this->session->userdata('user_type') == 'admin') {
	    	t_input('user_type');
			}
			t_input('email', 'class:validate[custom[email]]');
		?>
    {if $user_type eq 'seller'}
	    <?php t_input('display_name', "class:{$required}");?>
	    <?php t_input('address', "class:{$required}");?>
	    <?php t_input('phone', 'class:validate[custom[phone]]');?>
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
	    <?php t_input('address', "class:{$required}");?>
	    <?php t_input('postal_code', 'class:{$int}');?>
	    <?php t_input('phone', 'class:validate[custom[phone]]');?>
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
