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

	$.validator.addMethod("email", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
	}, "Please enter a valid email address.");
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
			
			for in
		});
			
	}();
	
	

	

	$("#first_name").blur(function() {
		var $first_name_val = $(this).val();
		if($first_name_val.length < 3) {
			$("#reg_btm").attr("disabled", true);
			$("#first_name_error").html("نام شما باید حداقل ۳ حرف داشته باشد.");
		} else {
			$("#first_name_error").html("");
			$("#reg_btm").attr("disabled", false);
		}
	});

	$("email").blur(function() {

	});
});
