<?php
class Admin extends MY_Controller {

	function index() {
		if ($this->_is_admin()) {
			$this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_seller_names();
			$this->load->view('index_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}

	function add_product() {
		if ($this->_is_admin()) {
			$product_name = $this->input->post('product_name');
			$seller_id = $this->input->post('seller');
			$description = $this->input->post('product_desc');
			$base_discount = $this->input->post('base_discount');
			$price = $this->input->post('product_price');
			$lower_limit = $this->input->post('lower_limit');
			//after validating other input, upload file
			$config['upload_path'] = './images/products';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';

      $this->load->library('upload', $config);
			$this->upload->do_upload();
			$upload_data = $this->upload->data();
			$this->load->model('product_model');
			$insert_result = $this->product_model->insert_product($product_name, $seller_id, $description,
			                                                      $base_discount, $price, $upload_data['file_name'], $lower_limit);
			if ($insert_result == TRUE) {
				// redirect to success place
				redirect('/admin/');
			} else {
				//add error
				$this->load->view('product_error');
			}
		} else {
			//not logged in or admin
			$this->load->view('access_denied');
		}
	}
	function _is_admin () {
		return ($this->session->userdata('is_logged_in') === TRUE &&
		        $this->session->userdata('user_type') === 'admin');
	}
}
