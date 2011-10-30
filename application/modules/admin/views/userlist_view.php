{block name=main_content}
<table>
	<thead>
		<tr>
			<th>نام کاربری</th>
			<th>پست الکترونیکی</th>
			<th>نام</th>
			<th>نام خانوادگی</th>
			<th>نوع کاربر</th>
			<th>زمان ایجاد حساب</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($users as $user) {
		echo '<tr>';
		foreach(array('username', 'email', 'first_name', 'last_name',
		              'user_type', 'creation_time') as $col) {
			echo '<td>' . $user[$col] . '</td>';
		}
		echo '<td><a href = "' . base_url() . 'admin/userlist/edit?id=' .
		     $user['id'] . '">ویرایش</a></td>';
		echo '<td><form method = "post" action = "'.base_url().
		     '/admin/userlist/delete"><input name = "id" value = "' . 
		     $user['id'] . '" type = "hidden"><input type = "submit" '.
		     'value = "حذف"></form></td>';
		echo '</tr>';
	}?>
	</tbody>
</table>
{/block}
