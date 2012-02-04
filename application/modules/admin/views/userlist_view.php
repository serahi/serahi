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
			<th><a href="<?php echo base_url();
                        if(isset($_GET['user_sort_by']) && $_GET['user_sort_by'] == 'uName' && $_GET['user_type'] == 'asc')
                        {
                            echo "admin/userlist/?user_sort_by=uName&user_type=desc";
                        }
                        else
                            echo "admin/userlist/?user_sort_by=uName&user_type=asc";?>"/>نام کاربری</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['user_sort_by']) && $_GET['user_sort_by'] == 'uEmail' && $_GET['user_type'] == 'asc')
                        {
                            echo "admin/userlist/?user_sort_by=uEmail&user_type=desc";
                        }
                        else
                            echo "admin/userlist/?user_sort_by=uEmail&user_type=asc";?>"/>پست الکترونیکی</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['user_sort_by']) && $_GET['user_sort_by'] == 'uFname' && $_GET['user_type'] == 'asc')
                        {
                            echo "admin/userlist/?user_sort_by=uFname&user_type=desc";
                        }
                        else
                            echo "admin/userlist/?user_sort_by=uFname&user_type=asc";?>"/>نام</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['user_sort_by']) && $_GET['user_sort_by'] == 'uLname' && $_GET['user_type'] == 'asc')
                        {
                            echo "admin/userlist/?user_sort_by=uLname&user_type=desc";
                        }
                        else
                            echo "admin/userlist/?user_sort_by=uLname&user_type=asc";?>"/>نام خانوادگی</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['user_sort_by']) && $_GET['user_sort_by'] == 'uType' && $_GET['user_type'] == 'asc')
                        {
                            echo "admin/userlist/?user_sort_by=uType&user_type=desc";
                        }
                        else
                            echo "admin/userlist/?user_sort_by=uType&user_type=asc";?>"/>نوع کاربر</a></th>
			
                        <th><a href="<?php echo base_url();
                        if(isset($_GET['user_sort_by']) && $_GET['user_sort_by'] == 'uTime' && $_GET['user_type'] == 'asc')
                        {
                            echo "admin/userlist/?user_sort_by=uTime&user_type=desc";
                        }
                        else
                            echo "admin/userlist/?user_sort_by=uTime&user_type=asc";?>"/>زمان ایجاد حساب</a></th>
			
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