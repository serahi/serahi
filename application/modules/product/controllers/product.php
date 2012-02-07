<?php

class Product extends MY_Controller {

    function view() {
        $id = $this->input->get('id');
        $this->load->model('product_model');
        $view_data['product'] = $this->product_model->get_product($id, $this->session->userdata('user_id'));

        $data['comcount'] = $this->product_model->get_comments($id);
        $this->load->library('pagination');
        $config['base_url'] = "http://localhost/serahi/product/view?id=" . $id;
        $config['total_rows'] = count($data['comcount']);
        $config['per_page'] = 6;
        $config['num_links'] = 20;
        $config['page_query_string'] = true;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);

        $view_data['comments'] = $this->product_model->get_limited_comments($id, $config['per_page'], $this->input->get('per_page'));
        
        $this->load->view('product_view', $view_data);
    }
         

        function edit_view() {
        $id = $this->input->get('id');
        $this->load->model('product_model');
//        $view_data['product'] = $this->product_model->get_product($id, $this->session->userdata('user_id'));

        $view_data['comment']['id']=$id;
        $this->load->view('edit_view', $view_data);
    }
    
    function add_comment() {
        $this->load->model('product_model');
        $this->product_model->add_comment($this->session->userdata('user_id'));
        redirect('product/view?id='.$this->input->post('product_id'));
    }

 
    function edit_comment() {
        //$this->load->model('product_model');
        //$this->product_model->edit_comment();        
        redirect('product/edit_view?id='.$this->input->post('comment_id'));
    }
    
    function save_edit_comment() {
        $this->load->model('product_model');
        $this->product_model->edit_comment();
        //redirect('product/view?id='.$this->input->post('product_id'));
    }


    function remove_comment() {
        $this->load->model('product_model');
        $this->product_model->remove_comment();
        redirect('product/view?id='.$this->input->post('product_id'));
    }

}
