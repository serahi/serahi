<?php

class News_management extends MY_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('news_model');
    }
    
    function index(){
        if (!_is_admin() ){
            $this->load->view('access_denied');
            return;
        }
        $data['news'] = $this->news_model->news_list();
        $this->load->view('news_panel', $data );
    }
    
    function add(){
        if (!_is_admin() ){
            $this->load->view('access_denied');
            return;
        }
        $this->load->view('add_news');
    }
    
    function add_news(){
        if (!_is_admin() ){
            $this->load->view('access_denied');
            return;
        }
        $this->news_model->add_news();
        redirect('admin/news_management');
    }
    
    function edit(){
        if (!_is_admin() ){
            $this->load->view('access_denied');
            return;
        }
        $id = $this->input->get('id');
        $data['new'] = $this->news_model->news_list($id);
        $this->load->view('edit_news', $data);
    }
    
    function update(){
        if (!_is_admin() ){
            $this->load->view('access_denied');
            return;
        }
        $this->news_model->update();
        redirect('admin/news_management');
    }
    
    function remove_news(){
        if (!_is_admin() ){
            $this->load->view('access_denied');
            return;
        }
        $this->load->model('news_model');
        $this->news_model->remove();
        $this->index();
    }
}
