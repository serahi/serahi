<?php

class Mtests extends MY_Controller{
	
	function test_get_prodocut(){
		$this->load->model('home_model');
		$this->db->query('truncate products;');
		$test_data = array(
			'product_name' => 'shalgham',
			'seller_id' => '1',
			'lower_limit' => '5',
			'description' => "amoo sabzi frush bale!",
			'image' => 'shalgham.jpeg',
			'base_discount' => '50'
			
		);
		$this->db->insert('products', $test_data);
		
		$result = $this->home_model->getall();
		$this->assertEqual(count($result),1);
		$test_data['id'] = $result[0]['id'];
		$this->assertEqual( $result[0], $test_data);
	}
}
