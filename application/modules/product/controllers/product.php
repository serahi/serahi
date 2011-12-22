<?php

class Product extends MY_Controller {

    function view() {
        $id = $this->input->get('id');
        $this->load->model('product_model');       
        $view_data = $this->product_model->get_product($id, $this->session->userdata('user_id'));
        $this->load->view('product_view', $view_data);
        
        //this part of code should replace the existing code to show comments but it causes a problem in view!!!!
        /*
        $view_data['product'] = $this->product_model->get_product($id, $this->session->userdata('user_id'));
        $view_data['comments'] = $this->product_model->get_comments($id);
        $this->load->view('product_view', $view_data);*/
    }

}
