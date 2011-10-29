<?php
require_once('../../simpletest/autorun.php');
require_once('../../simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

class Userlist_vtests extends WebTestCase {
	var $conn;
	function testUserListViewFilledWithUserNames () {
		$this->conn = pg_pconnect("host='localhost' dbname='serahi' user='postgres' password='Root3pg'");
		
		pg_query('TRUNCATE users;');
		$this->insert_user('admin', md5('admin'), 'admin', 'admin@serahi.ir',
			date('m-d-Y H:i:s'), 'مدیر', 'سایت', 'users');
		$this->insert_user('milad', md5('milad'), 'admin', 'miladbashiri@comp.iust.ac.ir',
			date('m-d-Y H:i:s'), 'milad', 'bashiri', 'sellers');
		$this->insert_user('hamed', 'gholizadeh', 'seller', 'hamed.gholizadeh.f@gmail.com',
			date('m-d-Y H:i:s'), 'hamed', 'gholizadeh', 'sellers');
		$this->post('http://localhost/serahi/user/login/login_check', array('username'=>'admin','password'=>'admin'));
		$this->get('http://localhost/serahi/admin/userlist');
		$this->assertText('hamed');
		$this->assertText('milad');
	}
	
	function insert_user ($username,$password,$user_type,$email,
	                      $creation_time,$first_name,
	                      $last_name, $table_name) {
		pg_query($this->conn, "INSERT INTO $table_name (username," .
			"password,user_type,email,creation_time," .
			"first_name,last_name) VALUES ('$username','$password'," . 
			"'$user_type','$email','$creation_time',".
			"'$first_name','$last_name');");
	}
}

$result = run_local_tests();
if (SimpleReporter::inCli()) {
    exit($result ? 0 : 1);
}