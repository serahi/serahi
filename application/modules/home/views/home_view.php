{block name=title}
سه‌راهـــــی
{/block}

{block name=script}
{literal}
<script type="text/javascript">

    //$(document).ready(function(){$(".bconfirm").easyconfirm();});




</script>
{/literal}
{/block}

{block name=main_content}
<?php
if (isset($products)) {
    echo '<div class="product">';
    $index = 0;
    foreach ($products as $item) {
        echo '<div class="item">';
        echo '<div class="item_pic">';
        echo '<img src="' . base_url() . 'images/products/' . $item['image'] . '"/> ';
        echo '</div>';
        echo '<div class="item_name"> <b> نام کالا: </b>' . $item['product_name'];

        echo '</div>';
        echo '<div class="item_price"> <b>  قیمت کالا: </b>' . $item['price'] . ' تومان';

        echo '</div>';
        echo '<div class="base_discount"> <b> تخفیف پایه: </b>' . $item['base_discount'] . ' درصد';

        echo '</div>';
        echo '<div class="lower_limit"> <b> حد نصاب: </b>' . $item['lower_limit'];

        echo '</div>';
        echo '<div class="sell_count"> <b> تعداد فروخته شده تا الان: </b>' . $item['sell_count'];
        echo '</div>';
        echo '<div class="description"><pre>' . $item['description'] . '</pre></div>';
        echo '<div class="buy">';

        if ($item['buying_state'] == 0) {
            echo ' <form method="post"   action="' . base_url() . 'home/buy" class="forms " > <input type="submit" value="خرید">  <input type="hidden" value="' . $item['id'] . '" name="product_id"></form> ';
        } elseif ($item['buying_state'] == 2) {
            echo ' <form method="post"   action="' . base_url() . 'home/buy" class="forms  buy_form " name="buying_form' . $index++ . '" > <input type="submit" class="bconfirm" value="خرید"  >  <input type="hidden" value="' . $item['id'] . '" name="product_id"></form> ';
        } elseif ($item['buying_state'] == 1) {
            echo '<div class="not_found_item">' . 'این کالا قبلاً توسط شما خریداری شده است!' . '</div>';
            echo '<div class="pursuit_code" > کدرهگیری شما:' . $item['pursuit_code'] . '</div>';
            echo ' <form method="post"  action="' . base_url() . 'home/cancel_transaction" class="forms cancel_buying" > <input type="submit" value="لغو خرید">  <input type="hidden" value="' . $item['id'] . '" name="product_id"></form> ';
        } elseif ($item['buying_state'] == 3) {
            echo '<div class="not_found_item">' . 'این کالا قبلاً توسط شما خریداری شده است!' . '</div>';
        }
        echo '</div>';

        echo '</div> ';
    }
    echo '</div>';
} elseif ($this->session->userdata('is_logged_in')) {
    echo "کالایی یافت نشد";
}
?>



{/block}