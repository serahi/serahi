{block name=main_content}
<table>
	<th>
		<td>نام کاربری</td>
		<td>پست الکترونیکی</td>
		<td>نام</td>
		<td>نام خانوادگی</td>
		<td>نوع کاربر</td>
		<td>زمان ایجاد حساب</td>
	</th>
	<tbody>
	<?php foreach($users as $user) {
		echo '<tr>';
		foreach(array('username', 'email', 'first_name', 'last_name',
		              'user_type', 'creation_time') as $col) {
			echo '<td>' . $user[$col] . '</td>';
		}
		echo '</tr>';
	}?>
	</tbody>
</table>
{/block}
