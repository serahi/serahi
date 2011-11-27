{block name=title}مدیریت کاربران{/block}

{block name=css}
<link rel="stylesheet" type="text/css" href="{$base_url}assets/style/admin.css" />
<link rel="stylesheet" type="text/css" href="{$base_url}assets/style/tables.css" />
{/block}

{block name=script}
<script language="javascript">
	$(document).ready(function() {
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
		{assign var=cols value=array(
					'username',
					'email',
					'first_name',
					'last_name',
					'user_type',
					'creation_time'
		)}
		{foreach $users as $user}
		<tr> 
			{foreach $cols as $col}
				<td>{$user.$col}</td>
			{/foreach}
			<td><a href = "{$base_url}admin/userlist/edit?id={$user.id}">ویرایش</a>
			<form class = "table_form" method = "post" action = "{$base_url}admin/userlist/delete">
				<input name = "id" value = "{$user.id}" type = "hidden">
				<input type = "submit" value = "حذف">
			</form></td>
		</tr>
		{/foreach}
	</tbody>
</table>
{/block} 