<?php

class Product extends MY_Controller {

    function view() {
        $id = $this->input->get('id');
        $this->load->model('product_model');
        $view_data['product'] = $this->product_model->get_product($id, $this->session->userdata('user_id'));
        $view_data['comments'] = $this->product_model->get_comments($id);
        $this->load->view('product_view', $view_data);
    }

    function add_comment() {
        $this->load->model('product_model');
        $this->product_model->add_comment();
        redirect('product/view?id='.$this->input->post('product_id'));
    }

    //not ready yet
    function edit_comment() {
        $this->load->model('product_model');
        $this->product_model->edit_comment();
        //redirect('product/view?id='.$this->input->post('product_id'));
    }

    //not ready yet
    function remove_comment() {
        $this->load->model('product_model');
        $this->product_model->remove_comment();
        //redirect('product/view?id='.$this->input->post('product_id'));
    }

}
