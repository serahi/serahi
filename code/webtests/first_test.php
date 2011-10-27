<?php

require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

class FirstTest extends WebTestCase
{
    function testText()
    {
        $this->get('http://localhost/serahi/vsample/');
        $this->assertText('hi');
		$this->assertTitle('first page');
    }
	function testForm()
	{
		
	}
}
