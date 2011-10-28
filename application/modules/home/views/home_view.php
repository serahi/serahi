{block name=title} <title>سه‌راهـــــی</title>
{/block}

{block name=main_content}
<table class="product">
	<tr><th>نام محصول</th><th>قیمت</th><th>تصویر</th><th></th></tr>
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
		?>
	</tbody>
</table>
{/block}