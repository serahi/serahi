<?php

$config['messages']['required'] = 'پر کردن "%s" الزامی است.';
$config['messages']['less_than'] = 'مقدار "%s" باید کمتر از %s باشد.';
$config['messages']['greater_than'] = 'مقدار "%s" باید بیشتر از %s باشد.';
$config['messages']['min_length'] = '"%s" باید حداقل %s کارکتر باشد.';
$config['messages']['max_length'] = '"%s" باید حداکثر %s کارکتر باشد.';
$config['messages']['exact_length'] = '"%s" باید دقیقا %s کارکتر باشد.';
$config['messages']['matches'] = '"%s" و "%s" یکسان نیستند.';
$config['messages']['valid_email'] = 'آدرس ای‌میل واردشده معتبر نیست.'; //Assuming every form has only one email address field.
$config['messages']['numeric'] = '"%s" باید یک مقدار عددی باشد.';
$config['messages']['integer'] = '"%s" باید یک مقدار عددی بدون اعشار باشد.';
$config['messages']['is_natural'] = '"%s" باید یک عدد بدون اعشار و غیرمنفی باشد.';
$config['messages']['is_natural_no_zero'] = '"%s" باید یک عدد بدون اعشار و مثبت باشد.';

/***** list of rules defined for each input field ******/

$config['product_name'] = 'required';
$config['product_price'] = 'required|greater_than[0]';
$config['base_discount'] = 'required|less_than[100]|greater_than[0]';
$config['lower_limit'] = 'required|is_natural_no_zero';
$config['duration'] = 'required|is_natural_no_zero';
