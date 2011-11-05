<?php

class Admin extends MY_Controller
{

	function index ()
	{
		if ($this->_is_admin()) {
			$this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_seller_names();
			$this->load->view('index_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}

	function add_product ()
	{
		if ($this->_is_admin()) {
			$this->load->library('form_validation');
			$config = array(
					array(
							'field' => 'product_name',
							'label' => 'نام محصول',
							'rules' => 'required|min_length[3]|max_length[31]'
					),
					array(
							'field' => 'product_price',
							'label' => 'قیمت واقعی',
							'rules' => 'required|greater_than[0]'
					),
					array(
							'field' => 'base_discount',
							'label' => 'میزان تخفیف',
							'rules' => 'required|less_than[100]'
					),
					array(
							'field' => 'lower_limit',
							'label' => 'حد نصاب',
							'rules' => 'required|is_natural_no_zero'
					),
			);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_message('required', '<hr/>وارد کردن %s لازم است.');
			$this->form_validation->set_message('min_length', '<hr/>%s باید حداقل، ۳ حرفی باشد.');
			$this->form_validation->set_message('max_length', '<hr/>%s باید حداکثر، ۳۱ حرفی باشد');
			$this->form_validation->set_message('less_than', '<hr/>%s باید بین ۰ تا ۱۰۰ باشد.');
			$this->form_validation->set_message('greater_than', '<hr/>%s باید بزرگتر از ۰ باشد.');
			$this->form_validation->set_message('is_natural_no_zero', '<hr/>%s باید عدد صحیح بزرگتر از ۰ باشد.');

			$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');
			if ($this->form_validation->run() == FALSE) {
				//invalid input form
				$this->load->model('seller_model');
				$view_data['sellers'] = $this->seller_model->get_seller_names();
				$this->load->view('index_view', $view_data);
			} else {
				//valid input form

				$product_name = $this->input->post('product_name');
				$seller_id = $this->input->post('seller');
				$description = $this->input->post('product_desc');
				$base_discount = $this->input->post('base_discount');
				$price = $this->input->post('product_price');
				$lower_limit = $this->input->post('lower_limit');
				//TODO: validate inputs
				$config['upload_path'] = './images/products';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';

				$this->load->library('upload', $config);
				$this->upload->do_upload();
				$upload_data = $this->upload->data();
				$this->load->model('product_model');
				$insert_result = $this->product_model->insert_product($product_name, $seller_id, $description, $base_discount, $price, $upload_data['file_name'], $lower_limit);
				if ($insert_result == TRUE) {
					// redirect to success place
					redirect('/admin/');
				} else {
					//add error
					$this->load->view('product_error');
				}
			}
		} else {
			//not logged in or admin
			$this->load->view('access_denied');
		}
	}

	function _is_admin ()
	{
		return ($this->session->userdata('is_logged_in') === TRUE && $this->session->userdata('user_type') === 'admin');
	}

}
