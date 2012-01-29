var inputs = {
		'username' : 'نام کاربری',
		'password' : 'رمز عبور',
		'password_confirm' : 'تکرار رمز عبور',
		'email' : 'آدرس پست‌الکترونیکی',
		'first_name' : 'نام',
		'last_name' : 'نام خانوادگی',
		'address' : 'آدرس دقیق',
                'pursuit_code': 'کد رهگیری',
		'phone': 'شماره‌ی تماس',
                'postal_code' : 'کد پستی',
                'address': 'آدرس',
		'seller_display_name': 'نام شرکت یا فروشگاه شما',
                'news_title': 'عنوان خبر',
                'news_content': 'متن خبر'

	};

$(document).ready(function() {
	
	var check_confirmation = function(){
		$( "#reg_btm" ).click(function(){
			if( $(".confirmation").attr('checked') != 'checked' ){
				alert("پیش از ثبت نام شما باید قوانین سایت را مطالعه کرده و پذیرفته باشید");
				return false;
			}
		});
			
	}();
		
//checking default values of submit and make inputs empty
	 var make_empty = function(){
		$(".forms").submit( function(){
			$(".check").each(function(){
				var name = $(this).attr('name');
				if ( $(this).val() == inputs[name] )
				{
					$(this).val('');
				}
			});
                        $("textarea.check").each(function(){
				var name = $(this).attr('name');
				if ( $(this).innerHTML == inputs[name] )
				{
					$(this).innerHTML = inputs[name];
				}
			});
		});
	};
	

	make_empty();
	var x = function(){
		var name = $(this).attr('name');

		if($(this).val() == "") {
			$(this).val(inputs[name]);
		}
	};
	var make_default = function(){
			$(".check").each(function(){
				var name = $(this).attr('name');
				if ( $(this).val() == '' )
				{
					$(this).val(inputs[name]) ;
				}
		});
		/*
		$(".check").unbind('blur');
		$(".check").blur();
		document.getElementById('password').blur();
		$(".check").blur(x);*/
	};
		$(".submit_form").validationEngine({
			'validationEventTrigger' : 'submit',
			'promptPosition' : 'topLeft'
			//onFailure : make_default
		});
	
	
	var check = function() {
		$(".check").focus(function() {
			var name = $(this).attr('name');
			if($(this).val() == inputs[name]) {
				$(this).val("");
			}
		});
		$(".check").blur(x);
	}();

	$(".pass").focus(function() {
		$(this).prop('type', 'password');
	});
	$(".pass").blur(function(){
		var name = $(this).attr('name');
		if ( $(this).val() == '' || $(this).val() == inputs[name] )
			$(this).prop('type', 'text');
	});
	
	
});




