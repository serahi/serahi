<?php

class mtests extends MY_Controller{
	
	function test_get_prodocut(){
		$this->load->model('home_model');
		$this->db->query('truncate products;');
		$test_data = array(
			'product_name' => 'shalgham',
			'seller_id' => '1',
			'lower_limig' => '5',
			'description' => "amoo sabzi frush bale!",
			'image' => 'shalgham.jpeg',
			'base_discount' => '50'
			
		);
		$this->db->insert('products', $test_data);
		
		$result = $this->home_model->getlist();
		$test_data['id'] = $result['id'];
		$this->assertEquals( $result, $test_data);
	}
}
