{block name=css}
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/admin.css" />
{/block}
{block name=script}
<script language="javascript">
$(document).ready(function (){
	$("tr:nth-child(odd)").addClass("odd");
});
</script>
{/block}
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
			<th>عملیات</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($users as $user) {
		echo '<tr>';
		foreach(array('username', 'email', 'first_name', 'last_name',
		              'user_type', 'creation_time') as $col) {
			echo '<td>' . $user[$col] . '</td>';
		}
	?>
			<td>
				<a href = "<?php echo base_url();?>admin/userlist/edit?id=<?php echo $user['id'];?>">
					ویرایش
				</a>
				<form class = "table_form" method = "post" action = "<?php echo base_url();?>/admin/userlist/delete">
					<input name = "id" value = "<?php echo $user['id'];?>" type = "hidden">
					<input type = "submit" value = "حذف">
				</form>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
{/block}
