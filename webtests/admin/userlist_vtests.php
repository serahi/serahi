<?php
require_once('../../simpletest/autorun.php');
require_once('../../simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

class Userlist_vtests extends WebTestCase {
	var $conn;
	function testUserListViewFilledWithUserNames () {
		$this->conn = pg_pconnect("host='localhost' dbname='serahi' user='postgres' password='Root3pg'");
		
		pg_query('TRUNCATE sellers;');
		$this->insert_user('milad', md5('milad'), 'admin', 'miladbashiri@comp.iust.ac.ir',
			date('m-d-Y H:i:s'), 'milad', 'milad', 'bashiri');
		$this->insert_user('hamed', 'gholizadeh', 'seller', 'hamed.gholizadeh.f@gmail.com',
			date('m-d-Y H:i:s'), 'hamed', 'hamed', 'gholizadeh');
		$this->post('http://localhost/serahi/user/login/login_check', array('username'=>'milad','password'=>'milad'));
		$this->get('http://localhost/serahi/admin/userlist_vtests');
		$this->assertText('hamed');
		$this->assertText('milad');
	}
	
	function insert_user ($username,$password,$user_type,$email,
	                      $creation_time,$display_name,$first_name,
						  $last_name) {
		pg_query($this->conn, "INSERT INTO sellers (username," .
			"password,user_type,email,creation_time,display_name," .
			"first_name,last_name) VALUES ('$username','$password'," . 
			"'$user_type','$email','$creation_time','$display_name',".
			"'$first_name','$last_name');");
	}
}

$result = run_local_tests();
if (SimpleReporter::inCli()) {
    exit($result ? 0 : 1);
}