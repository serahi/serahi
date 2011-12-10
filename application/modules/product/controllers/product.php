<?php

class Product extends MY_Controller
{
	function view ()
	{
		$id = $this->input->get('id');
		$this->load->model('product_model');
		$view_data['item'] = $this->product_model->get_product($id, $this->session->userdata('user_id'));
		$this->load->view('product_view', $view_data);
	}
}
