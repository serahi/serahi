{block name=title}
پنل فروشنده
{/block}

{block name=main_content}

	
		<?php
			if(isset($products)) {
				echo '<div class="product">';
				foreach ($products as $item) {
					echo '<div class="item">';
						
						echo '<div class="item_name"> <b> نام کالا: </b>'. $item['product_name'];
						
						echo '</div>';
						echo '<div class="lower_limit"> <b> حد نصاب: </b>' .$item['lower_limit'];
						
						echo '</div>';
						echo '<div class="sell_count"> <b> تعداد فروخته شده تا الان: </b>' .$item['sell_count'];
						echo '</div>';
						
					echo '</div> ';
				}
				echo '</div>';	
			}elseif( $this->session->userdata('is_logged_in') ){
				echo "کالایی یافت نشد";
			}
		?>
	

{/block}