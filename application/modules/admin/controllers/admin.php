<?php

class Admin extends MY_Controller
{
    
        public $ck_config = array();
        
	function index ()
	{
		$this->load->model('product_model');
		$this->load->model('seller_model');
                
                if($this->input->get('product_sort_by') == 'pName')
                {
                    $view_data['products'] = $this->product_model->get_products("product_name",$this->input->get('product_type'));
                }
                elseif($this->input->get('product_sort_by') == 'pPrice')
                {
                    $view_data['products'] = $this->product_model->get_products("price",$this->input->get('product_type'));
                }
                elseif($this->input->get('product_sort_by') == 'pDiscount')
                {
                    $view_data['products'] = $this->product_model->get_products("base_discount",$this->input->get('product_type'));
                }
                elseif($this->input->get('product_sort_by') == 'pLimit')
                {
                    $view_data['products'] = $this->product_model->get_products("lower_limit",$this->input->get('product_type'));
                }
                elseif($this->input->get('product_sort_by') == 'pSname')
                {
                    $view_data['products'] = $this->product_model->get_products("display_name",$this->input->get('product_type'));
                }
                elseif($this->input->get('product_sort_by') == 'pStime')
                {
                    $view_data['products'] = $this->product_model->get_products("start_schedule",$this->input->get('product_type'));
                }
                elseif($this->input->get('product_sort_by') == 'pDtime')
                {
                    $view_data['products'] = $this->product_model->get_products("duration",$this->input->get('product_type'));
                }
                else
                    $view_data['products'] = $this->product_model->get_products('nothing','nothing');
                
                
                
                
                if($this->input->get('seller_sort_by') == 'fName')
                {
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers("first_name",$this->input->get('seller_type'));
                }
                elseif($this->input->get('seller_sort_by') == 'fLastName')
                {
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers("last_name",$this->input->get('seller_type'));
                }
                elseif($this->input->get('seller_sort_by') == 'fNumber')
                {
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers("phone",$this->input->get('seller_type'));
                }
                else
                    $view_data['sellers'] = $this->seller_model->get_unapproved_sellers('nothing','nothing');
		$this->load->view('index_view', $view_data);
	}

	function product_form ()
	{
		$this->load->model('seller_model');
		$view_data['sellers'] = $this->seller_model->get_approved_sellers();
                
                $this->ck_editor_config();
                $view_data['ck_config'] = $this->ck_config;
		$this->load->view('add_product_view', $view_data);
	}

	function add_product ()
	{                
		$this->load->library('validator');
		$validated = $this->validator->validate(array(
			'product_name',
			'price',
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
					'price', //
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
			'price',
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
					'price',
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
                
                $this->ck_editor_config();
                $view_data['ck_config'] = $this->ck_config;
		$this->load->view('edit_product_view', $view_data );
	}
        
        function  ck_editor_config()
        {
                $this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
		//Ckeditor's configuration
		$this->ck_config['ckeditor'] = array(
 
			//ID of the textarea that will be replaced
			'id' 	=> 	'content',
			'path'	=>	'js/ckeditor',
 
			//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height
                                
 
			),
 
			//Replacing styles from the "Styles tool"
			'styles' => array(
 
				//Creating a new style named "style 1"
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 	=> 	'Blue',
						'font-weight' 	=> 	'bold'
					)
				),
 
				//Creating a new style named "style 2"
				'style 2' => array (
					'name' 	=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)				
			)
		);
        }
}
