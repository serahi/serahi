$(document).ready(function(){
	
	$('.buy_form').submit(function(e){
		
		//var elem = $(this).closest('.item');
		//var name = $(this).attr('name');
		$(this).prop('name','buying_form');
		
		$.confirm({
			'title'		: 'تائید خرید',
			'message'	: 'شما بیش از یک‌بار نمی‌توانید از خرید خود انصراف دهید <br/> آیا مایل به ادامه‌ی خرید هستید؟',
			'buttons'	: {
				'بله'	: {
					'class'	: 'blue',
					'action': function(){ document.buying_form.submit();}
				},
				'خیر'	: {
					'class'	: 'gray',
					'action': function(){ return false; }	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
		
		e.preventDefault(); 
	});
});	

