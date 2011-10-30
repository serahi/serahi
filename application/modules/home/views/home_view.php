{block name=title} <title>سه‌راهـــــی</title>
{/block}

{block name=main_content}

	<!-- <tr><th>نام محصول</th><th>قیمت</th><th>تصویر</th><th></th></tr> 
	<tbody>
		<?php 
		if (isset($products)) {
			foreach ($products as $row) {
				echo '<tr> <td>' . $row['product_name'] . "</td> ";
				echo "<td>" . $row['price'] . "</td>";
				echo "<td>" . $row['image'] . "</td>";
				if (!$row['is_bought']) {
					echo '<td> <form method="post" action="home/buy" > <input type="submit" value="خرید">  <input type="hidden" value="' . $row['id'] . '" name="product_id"></form> </td> </tr>';
				} else {
					echo '<td>' . 'خریداری شده است' . '</td> </tr>';
				}
			}
		}
		
		?> -->
		
		<?php
			if(isset($products)) {
				echo '<div class="product">';
				foreach ($products as $item) {
					echo '<div class="item">';
						echo '<div class="item_pic">';
							echo '<img src="'.base_url().'images/products/'.$item['image'].'"/> ';
						echo '</div>';
						echo '<div class="item_name"> <b> نام کالا: </b>'. $item['product_name'];
							
						echo '</div>';
						echo '<div class="item_price"> <b>  قیمت کالا: </b>' . $item['price'];
						
						echo '</div>';
						echo '<div class="base_discount"> <b> تخفیف پایه: </b>' . $item['base_discount'].' درصد';
						
						echo '</div>';
						echo '<div class="lower_limit"> <b> حد نصاب: </b>' .$item['lower_limit'];
						
						echo '</div>';
						echo '<div class="sell_count"> <b> تعداد فرخته شده: </b>' .$item['sell_count'];
						echo '</div>';
						echo '<div class="description"><pre>'.$item['description'].'</pre></div>';
						echo '<div class="buy">';
							if (!$item['is_bought']) {
								echo ' <form method="post" action="home/buy" > <input type="submit" value="خرید">  <input type="hidden" value="' . $row['id'] . '" name="product_id"></form> ';
							} else {
								echo '<div class="not_found_item">'. 'این کالا قبلاً توسط شما خریداری شده است!'. '</div>' ;
							}
						echo '</div>';
						
					echo '</div> ';
				}
				echo '</div>';	
			}elseif( $this->session->userdata('is_logged_in') ){
				echo "کالایی یافت نشد";
			}
		?>
	

{/block}