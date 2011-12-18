<?php

class News_management extends MY_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('news_model');
    }
    
    function index(){
        $data['news'] = $this->news_model->news_list();
        $this->load->view('news_panel', $data );
    }
    
    function add(){
        $this->load->view('add_news');
    }
    
    function add_news(){
        $this->news_model->add_news();
        redirect('admin/news_management');
    }
    
    function edit(){
        $id = $this->input->get('id');
        $data['new'] = $this->news_model->news_list($id);
        $this->load->view('edit_news', $data);
    }
    
    function update(){
        $this->news_model->update();
        redirect('admin/news_management');
    }
    
    function remove_news(){
        $this->load->model('news_model');
        $this->news_model->remove();
        $this->index();
    }
}
