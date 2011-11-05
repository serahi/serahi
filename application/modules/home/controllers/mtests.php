<?php

class Mtests extends MY_Controller
{

	function test_get_prodocut ()
	{
		$this->load->model('home_model');
		$this->db->query('truncate products;');
		$test_data = array(
				'id' => '7',
				'product_name' => 'لپ تاپ',
				'lower_limit' => '5',
				'description' => "ایران رهجو",
				'image' => 'laptop.jpeg',
				'base_discount' => '2',
				'price' => '13500000',
		);
		$this->db->insert('products', $test_data);

		$test_data['is_bought'] = FALSE;
		$test_data['sell_count'] = '0';

		$result = $this->home_model->get_list();
		$this->assertEqual(count($result), 1);
		$test_data['id'] = $result[0]['id'];
		$this->assertEqual($result[0], $test_data);
	}

}
