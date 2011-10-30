<?php
require_once('../../simpletest/autorun.php');
require_once('../../simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

class Vtests extends WebTestCase {
	function testIndexViewFilledWithSellerNames () {
		$conn = pg_pconnect("host='localhost' dbname='serahi' user='postgres' password='Root3pg'");
		
		pg_query('TRUNCATE sellers;');
		
		$result = pg_query($conn, "INSERT INTO sellers (username," .
			"password,user_type,email,creation_time,display_name," .
			"first_name,last_name) VALUES ('milad','milad','seller'," .
			"'miladbashiri@comp.iust.ac.ir','" . date('m-d-Y H:i:s') .
			"','milad','milad','bashiri');");
		
		$result = pg_query($conn, "INSERT INTO sellers (username," .
			"password,user_type,email,creation_time,display_name," .
			"first_name,last_name) VALUES ('hamed','75555','seller'," .
			"'hamed.gholizadeh.f@gmail.com','" . date('m-d-Y H:i:s') .
			"','hamed','gholizadeh','gholizadeh');");
		
		$this->get('http://localhost/serahi/admin/vtests');
		$this->assertText('hamed');
		$this->assertText('milad');
	}
}

$result = run_local_tests();
if (SimpleReporter::inCli()) {
    exit($result ? 0 : 1);
}