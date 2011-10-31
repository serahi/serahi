<?php

require_once('../../simpletest/autorun.php');
require_once('../../simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

class Vtests extends WebTestCase{
	
	function testTitle(){
		$this->get('http://localhost/serahi/home/');
		$this->assertTitle('سه‌راهـــــی');
	}
}

$result = run_local_tests();
if (SimpleReporter::inCli()) {
    exit($result ? 0 : 1);
}