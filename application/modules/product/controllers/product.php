<?php

class Product extends MY_Controller {

    function view() {
        $id = $this->input->get('id');
        $this->load->model('product_model');
        $view_data['product'] = $this->product_model->get_product($id, $this->session->userdata('user_id'));
        $view_data['comments'] = $this->product_model->get_comments($id);
                
       // echo 'hamed';
       /* $this->load->library('pagination');
        $config['base_url'] = "http://localhost/serahi/product/view?id=".$id;
        $config['total_rows'] = $this->db->get('products')->num_rows();
        $config['per_page'] = 10;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);

        $this->load->model('product_model');
        $array['products'] = $this->product_model->get_list($config['per_page'], $this->uri->segment(3));
        $this->load->view('home_view', $array);
        

*/
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
