<?php
class Admin extends MY_Controller {

    function index() {
        if ($this->session->userdata('is_logged_in') === TRUE &&
                $this->session->userdata('user_type') === 'admin') {
            $this->load->model('seller_model');
            $view_data['sellers'] = $this->seller_model->get_seller_names();
            $this->load->view('index_view', $view_data);
        } else {
            $this->load->view('access_denied');
        }
    }

    function add_product() {
        if ($this->session->userdata('is_logged_in') === TRUE &&
                $this->session->userdata('user_type') === 'admin') {
            /* $this->load->library('form_validation');
              $config = array(
              array(
              'field' => 'product_name',
              'label' => 'نام محصول',
              'rules' => 'required|min_length[3]|max_length[31]'
              ),
              array(
              'field' => 'product_price',
              'label' => 'قیمت واقعی',
              'rules' => ''
              ),
              array(
              'field' => 'base_discount',
              'label' => 'میزان تخفیف',
              'rules' => ''
              ),

              ); */
            $product_name = $this->input->post('product_name');
            $seller_id = $this->input->post('seller');
            $description = $this->input->post('product_desc');
            $base_discount = $this->input->post('base_discount');
            $price = $this->input->post('product_price');
            $this->load->model('product_model');
            $insert_result = $this->product_model->insert_product($product_name, $seller_id, $description, $base_discount, $price);
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

    function pic_upload() {
        $this->load->model('image_model');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048'; //2 meg
        $this->load->library('upload');
        foreach ($_FILES as $key => $value) {
            if (!empty($key['name'])) {
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($key)) {
                    $errors[] = $this->upload->display_errors();
                } else {
                    $this->Process_image->process_pic();
                }
            }
        }
        $data['success'] = 'Thank You, Files Upladed!';
        $this->load->view('upload/upload_pictures', $data);
    }

}

