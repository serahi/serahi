<?php

class Mtests extends MY_Controller
{
	function testGetSellersWithSingleSeller ()
	{
		$this->db->query('truncate sellers;');
		$this->db->insert('sellers', array(
				'username' => 'milad',
				'password' => 'milad',
				'user_type' => 'seller',
				'email' => 'miladbashiri@comp.iust.ac.ir',
				'creation_time' => date('m-d-Y H:i:s'),
				'display_name' => 'milad',
				'first_name' => 'milad',
				'last_name' => 'bashiri'
		));
		$this->load->model('seller_model');
		$data = $this->seller_model->get_seller_names();
		$this->assertEqual(count($data), 1);
		$this->assertEqual($data[0]['display_name'], 'milad');
	}

}
