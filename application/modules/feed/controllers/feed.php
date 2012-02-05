<?php

class Feed extends MY_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->helper('xml');
        $this->load->helper('text');
        $this->load->model('posts_model');
    }
    
    function index(){
        $data['posts'] = $this->posts_model->get_posts(10);
        $this->load->view('feed', $data);
    }
}