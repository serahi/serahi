<?php

class Admin extends MY_Controller {

	function index ()
	{
		$this->load->model('product_model');
                $this->load->model('seller_model');
		$view_data['products'] = $this->product_model->get_products();
                $view_data['sellers'] = $this->seller_model->get_unapproved_sellers();
		$this->load->view('index_view', $view_data);
	}
	
	function product_form ()
	{
		if (_is_admin()) {
			$this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_seller_names();
			$this->load->view('add_product_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}

    function add_product() {
        if (_is_admin()) {
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
            //$this->form_validation->set_message('min_length', '<hr/>%s باید حداقل، ۳ حرفی باشد.');
            //$this->form_validation->set_message('max_length', '<hr/>%s باید حداکثر، ۳۱ حرفی باشد');
            $this->form_validation->set_message('less_than', '<hr/>%s باید بین ۰ تا ۱۰۰ باشد.');
            $this->form_validation->set_message('greater_than', '<hr/>%s باید بزرگتر از ۰ باشد.');
            $this->form_validation->set_message('is_natural_no_zero', '<hr/>%s باید عدد صحیح بزرگتر از ۰ باشد.');

			$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');
			if ($this->form_validation->run() == FALSE) {
				//invalid input form
				$this->load->model('seller_model');
				$view_data['sellers'] = $this->seller_model->get_seller_names();
				$this->load->view('add_product_view', $view_data);
			} else {
				//valid input form
				list($product_name,  $seller_id, $description,
				     $base_discount, $price, $lower_limit,
				     $start_schedule, $start_time, $duration
				) = _post_values(array(
					 'product_name', 'seller', 'product_desc',
					 'baes_discount', 'product_price', 'lower_limit',
					 'start_schedule', 'start_time', 'duration'
				));
				
				//TODO: validate inputs
				$config['upload_path'] = './images/products';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';

				$this->load->library('upload', $config);
				$this->upload->do_upload();
				$upload_data = $this->upload->data();
				$this->load->model('product_model');
				$insert_result = $this->product_model->insert_product($product_name,
				                                                      $seller_id,
				                                                      $description,
				                                                      $base_discount,
				                                                      $price,
				                                                      $upload_data['file_name'],
				                                                      $lower_limit,
																	  $start_schedule,
																	  $start_time,
																	  $duration);
				redirect('/admin/');
			}
		} else {
			//not logged in or admin
			$this->load->view('access_denied');
		}
	}
        
        function approving_seller()
        {
            $this->load->model('seller_model');
            $this->seller_model->approve();
            $this->index();
        }
}
