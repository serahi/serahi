<?php

class Login extends MY_Controller{
    
    var $data;
    
    function __construct(){
        parent::__construct();
        $this->lang->load('user', 'farsi');
    }
    
    function index(){
        if($this->is_logged_in() )
            redirect('home');
        $this->load->view('login_form');
    }
    
    function login_check(){
        
        $this->load->model('membership_model');
        $name = $this->membership_model->validate_user();
        //echo $name['last_name']; die();
        if( $name != NULL ){
            $user_dt = array(
                'username' => $this->input->post('username'),
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'is_logged_in' => TRUE
            );
            $this->session->set_userdata($user_dt);
            redirect('home');
        }
        else{
            $data['error_msg'] = lang('wrong_user_or_pass');
            $data['entered_username'] = $this->input->post('username');
            $this->load->view('login_form', $data);
            
        }
    }
    
    function is_logged_in(){
        return $this->session->userdata('is_logged_in');
    }
    
    function sign_up(){
        if( $this->is_logged_in() ){
            redirect('site');
        }
        else{
            $data['main_content'] = 'sign_up_form';
            $this->load->view('include/template', $data);
        }
    }
    
    function register(){
        $this->load->library('form_validation');
        $config = array(
          array(
            'field' => 'first_name',
            'label' => 'نام',
            'rules' => 'required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'last_name',
            'label' => 'نام‌ خانوادگی',
            'rules' => 'required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'username',
            'label' => 'نام‌کاربری',
            'rules' => 'required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'password',
            'label' => 'رمز عبور',
            'rules' => 'required|min_length[9]|max_length[31]'
            ),
          array(
            'field' => 'c_password',
            'label' => 'تکرار رمز عبور',
            'rules' => 'required|min_length[9]|max_length[31]'
            ),
          array(
            'field' => 'mobile',
            'label' => 'شماره تلفن همراه',
            'rules' => 'required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'state',
            'label' => 'استان',
            'rules' => 'required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'city',
            'label' => 'شهر',
            'rules' => 'required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'address',
            'label' => 'آدرس',
            'rules' => 'required|min_length[3]|max_length[127]'
            ),
          array(
            'field' => 'email',
            'label' => 'پست الکترونیکی',
            'rules' => 'trim|valid_email|required|min_length[3]|max_length[31]'
            ),
          array(
            'field' => 'postal_code',
            'label' => 'کد پستی',
            'rules' => 'required|min_length[3]|max_length[31]'
            )
          
        );
        
        
        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', '<hr/>وارد کردن %s لازم است.');
        $this->form_validation->set_message('valid_email', '<hr/>آدرس پست‌الکترونیک وارد شده معتبر نمی‌باشد.');
        //$this->form_validation->set_message('valid_email', '%s باید حداقل ۳ حرف داشته باشد.' );
        //$this->form_validation->set_message();
        //$this->form_validation->set_message();
        $this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');
    
        if( $this->form_validation->run() == FALSE ){
            $this->sign_up();
            
        }else{
            $this->load->model('membership_model');
            if($this->membership_model->insert_member()){
                $data['main_content'] = 'welcome_new_user';
                $this->load->view('include/template', $data);
            }else{
                echo "failed";
            }
        }
    }
    
    function logout(){
        $this->session->sess_destroy();
        redirect('site');
    }
}