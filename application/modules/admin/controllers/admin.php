<?php

class Admin extends MY_Controller
{

	function index ()
	{
		$this->load->model('product_model');
		$this->load->model('seller_model');
		$view_data['products'] = $this->product_model->get_products();
                if($this->input->get('sort_by') == 'fName')
                {
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers("first_name",$this->input->get('type'));
                }
                elseif($this->input->get('sort_by') == 'fLastName')
                {
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers("last_name",$this->input->get('type'));
                }
                elseif($this->input->get('sort_by') == 'fNumber')
                {
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers("phone",$this->input->get('type'));
                }
                else
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers('nothing','nothing');
		$this->load->view('index_view', $view_data);
	}

	function product_form ()
	{
		$this->load->model('seller_model');
		$view_data['sellers'] = $this->seller_model->get_approved_sellers();
		$this->load->view('add_product_view', $view_data);
	}

	function add_product ()
	{
		$this->load->library('validator');
		$validated = $this->validator->validate(array(
			'product_name',
			'product_price',
			'base_discount',
			'lower_limit',
			'duration'
		));
		
		if ($validated == FALSE) {
			//invalid input form
			$this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_seller_names();
			$this->load->view('add_product_view', $view_data);
		} else {
			//valid input form
			list ($product_name, $seller_id, $description, $base_discount, $price, $lower_limit, $start_schedule, $start_time, $duration) = _post_values(array(
					'product_name', //
					'seller',
					'product_desc',
					'base_discount', //
					'product_price', //
					'lower_limit', //
					'start_schedule',
					'start_time',
					'duration' //
			), true);
			$config['upload_path'] = './images/products';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';

			$this->load->library('upload', $config);
			$this->upload->do_upload();
			$upload_data = $this->upload->data();

			$this->load->model('product_model');
			$insert_result = $this->product_model->insert_product($product_name, $seller_id,
                                $description,$base_discount, $price, $upload_data['file_name'],
                                $lower_limit, $start_schedule, $start_time, $duration);
                        
			redirect('/admin/');
		}
	}

	function save_product ()
	{
		$this->load->library('validator');
		$validated = $this->validator->validate(array(
			'product_name',
			'product_price',
			'base_discount',
			'lower_limit',
			'duration'
		));
		if ($validated == FALSE) {
			//invalid input form
			$this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_seller_names();
			$this->load->view('add_product_view', $view_data);
		} else {
			//valid input form
			list ($id, $product_name, $seller_id, $description, $base_discount, $price, $lower_limit, $start_schedule, $start_time, $duration) = _post_values(array(
					'id',
					'product_name',
					'seller',
					'product_desc',
					'base_discount',
					'product_price',
					'lower_limit',
					'start_schedule',
					'start_time',
					'duration'
			), true);
			$config['upload_path'] = './images/products';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';

			$this->load->library('upload', $config);
			$this->upload->do_upload();
			$upload_data = $this->upload->data();

			$this->load->model('product_model');
			$insert_result = $this->product_model->update_product($id, $product_name, $seller_id, $description, $base_discount, $price, $upload_data['file_name'], $lower_limit, $start_schedule, $start_time, $duration);
			redirect('admin/');
		}
	}

	function approving_seller ()
	{
		$this->load->model('seller_model');
		$this->seller_model->approve();
		redirect('admin');
	}

	function delete_product ()
	{
		$id = $this->input->post('id');
		$this->load->model('product_model');
		$this->product_model->delete_product($id);
		redirect('admin');
	}

	function edit_product ()
	{
		$id = $this->input->get('id');
		$this->load->model('product_model');
		$view_data = $this->product_model->get_product($id);
		$this->load->model('seller_model');
		$view_data['sellers'] = $this->seller_model->get_seller_names();
		$this->load->view('edit_product_view', $view_data);
	}
}
