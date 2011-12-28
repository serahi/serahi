<?php
$db_name = 'serahi';

function connect ()
{
	return pg_connect("host=localhost port=5432 dbname=serahi user=postgres password=Root3pg");
}

function query ($string)
{
	$db = connect();
	$result = pg_query($string);
	return pg_fetch_all($result);
}

function get_results ()
{
	
}

function do_backup ()
{
	echo "Step 1: Test Environment Setup\n";
	echo "...Performing database backup.\n";
	exec('expect scripts/backup_script.exp serahi Root3pg', $output);
	echo "...Clearing current data.\n";
	truncate_tables();
	echo "...Filling database with test data.\n";
	echo "Step n: Test Environment Tear Down.\n";
	echo "Restoring database...\n";
	exec('expect scripts/restore_script.exp serahi Root3pg');
	echo "Step n completed.\n";
	//print_r(query("select * from users"));
	//echo "\n****************************************************\n";
}

function truncate_tables ()
{
	$db = connect();
	pg_query('truncate transactions;'.
	         'truncate posts_rss;'.
					 'truncate news;'.
					 'truncate products;'.
					 'truncate sellers;'.
					 'truncate customers;'.
					 'truncate users;');
	
}
