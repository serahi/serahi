{block name=title} <title>سه‌راهـــــی</title>
{/block}

{block name=main_content}
<table class="product">
	<th><td>نام‌محصول</td><td>قیمت</td><td>تصویر</td><td></td></th>
	<tbody>
		<?php
		if (isset($products)) {
			foreach ($products as $row) {
				echo '<tr> <td>' . $row['product_name'] . "</td> ";
				echo "<td>" . $row['price'] . "</td>";
				echo "<td>" . $row['image'] . "</td>";
				if (!$row['is_bought']) {
					echo '<td> <form method="post" action="home/buy" > <input type="hidden" value="' . $row['id'] . '" name="product_id"> <input type="submit" value="خرید"> </form> </td> </tr>';
				} else {
					echo '<td>' . 'خریداری شده است' . '</td>';
				}
			}
		}
		?>
	</tbody>
</table>
{/block}