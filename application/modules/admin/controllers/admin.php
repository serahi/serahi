<?php

class Admin extends MY_Controller
{

	function index ()
	{
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$this->load->model('product_model');
		$this->load->model('seller_model');
		$view_data['products'] = $this->product_model->get_products();
		$view_data['sellers'] = $this->seller_model->get_unapproved_sellers();
		$this->load->view('index_view', $view_data);
	}

	function product_form ()
	{
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$this->load->model('seller_model');
		$view_data['sellers'] = $this->seller_model->get_approved_sellers();
		$this->load->view('add_product_view', $view_data);
	}

	function add_product ()
	{
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$this->load->library('form_validation');
		$config = array(
				array(
						'field' => 'product_name',
						'label' => 'نام محصول',
						'rules' => 'required'
				),
				array(
						'field' => 'product_price',
						'label' => 'قیمت واقعی',
						'rules' => 'required|greater_than[0]'
				),
				array(
						'field' => 'base_discount',
						'label' => 'میزان تخفیف',
						'rules' => 'required|less_than[100]|greater_than[0]'
				),
				array(
						'field' => 'lower_limit',
						'label' => 'حد نصاب',
						'rules' => 'required|is_natural_no_zero'
				),
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '<hr/>وارد کردن %s لازم است.');
		$this->form_validation->set_message('less_than', '<hr/>%s باید بین کمتر از %d باشد.');
		$this->form_validation->set_message('greater_than', '<hr/>%s باید بزرگتر از %d باشد.');
		$this->form_validation->set_message('is_natural_no_zero', '<hr/>%s باید عدد صحیح بزرگتر از ۰ باشد.');

		$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');
		if ($this->form_validation->run() == FALSE) {
			//invalid input form
			$this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_seller_names();
			$this->load->view('add_product_view', $view_data);
		} else {
			//valid input form
			list ($product_name, $seller_id, $description, $base_discount, $price, $lower_limit, $start_schedule, $start_time, $duration) = _post_values(array(
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
			$insert_result = $this->product_model->insert_product($product_name, $seller_id,
                                $description,$base_discount, $price, $upload_data['file_name'],
                                $lower_limit, $start_schedule, $start_time, $duration);
                        
			redirect('/admin/');
		}
	}

	function save_product ()
	{
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$this->load->library('form_validation');
		$config = array(
				array(
						'field' => 'product_name',
						'label' => 'نام محصول',
						'rules' => 'required'
				),
				array(
						'field' => 'product_price',
						'label' => 'قیمت واقعی',
						'rules' => 'required|greater_than[0]'
				),
				array(
						'field' => 'base_discount',
						'label' => 'میزان تخفیف',
						'rules' => 'required|less_than[100]|greater_than[0]'
				),
				array(
						'field' => 'lower_limit',
						'label' => 'حد نصاب',
						'rules' => 'required|is_natural_no_zero'
				),
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '<hr/>وارد کردن %s لازم است.');
		$this->form_validation->set_message('less_than', '<hr/>%s باید کمتر از %d باشد.');
		$this->form_validation->set_message('greater_than', '<hr/>%s باید بزرگتر از %d۰ باشد.');
		$this->form_validation->set_message('is_natural_no_zero', '<hr/>%s باید عدد صحیح بزرگتر از ۰ باشد.');

		$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');
		if ($this->form_validation->run() == FALSE) {
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
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$this->load->model('seller_model');
		$this->seller_model->approve();
		redirect('admin');
	}

	function delete_product ()
	{
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$id = $this->input->post('id');
		$this->load->model('product_model');
		$this->product_model->delete_product($id);
		redirect('admin');
	}

	function edit_product ()
	{
		if (!_is_admin()) {
			$this->load->view('access_denied');
			return;
		}
		$id = $this->input->get('id');
		$this->load->model('product_model');
		$view_data = $this->product_model->get_product($id);
		$this->load->model('seller_model');
		$view_data['sellers'] = $this->seller_model->get_seller_names();
		$this->load->view('edit_product_view', $view_data);
	}


}
