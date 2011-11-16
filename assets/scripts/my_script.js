$(document).ready(function() {

	var inputs = {
		'username' : 'نام کاربری',
		'password' : 'رمز عبور',
		'passconf' : 'تکرار رمز عبور',
		'email' : 'آدرس پست‌الکترونیکی',
		'first_name' : 'نام',
		'last_name' : 'نام خانوادگی',
		'address' : 'آدرس دقیق',
		'phone': 'شماره‌ی تماس',
		'seller_display_name': 'نام شرکت یا فروشگاه شما'

	};

	
	var check = function() {
		$(".check").focus(function() {
			var name = $(this).attr('name');
			if($(this).val() == inputs[name]) {
				$(this).val("");
			}
		});
		$(".check").blur(function() {
			var name = $(this).attr('name');

			if($(this).val() == "") {
				$(this).val(inputs[name]);
			}
		});
	}();

	$(".pass").focus(function() {
		$(this).prop('type', 'password');
	});
	$(".pass").blur(function(){
		var name = $(this).attr('name');
		if ( $(this).val() == '' || $(this).val() == inputs[name] )
			$(this).prop('type', 'text');
	})
	
	var check_confirmation = function(){
		$( "#reg_btm" ).click(function(){
			if( $(".confirmation").attr('checked') != 'checked' ){
				alert("پیش از ثبت نام شما باید قوانین سایت را مطالعه کرده و پذیرفته باشید");
				return false;
			}
			$(".check").each(function(){
				var name = $(this).attr('name');
				if ( $(this).val() == inputs[name] )
				{
					$(this).val('');
				}
			});
		});
			
	}();
	
});
