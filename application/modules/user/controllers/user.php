<?php

class User extends MY_Controller {

    var $data;

    function __construct() {
        parent::__construct();
        $this->lang->load('user', 'farsi');
    }

    function login() {
        if ($this->is_logged_in())
            redirect('home');
        $this->load->view('login_form');
    }

    function login_check() {

        $this->load->model('membership_model');
        $name = $this->membership_model->validate_user();
        //echo $name['last_name']; die();
        if ($name != NULL) {
            $user_session_data = array(
                'username' => $this->input->post('username'),
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'user_id' => $name['id'],
                'user_type' => $name['user_type'],
                'is_logged_in' => TRUE
            );
            $this->session->set_userdata($user_session_data);
            if ($name['user_type'] === 'customer') {
                redirect('home');
            } elseif ($name['user_type'] === 'seller') {
                redirect('seller');
            } elseif ($name['user_type'] === 'admin') {
                redirect('admin');
            }
        } else {
            $data['error_msg'] = lang('wrong_user_or_pass');
            $data['entered_username'] = $this->input->post('username');
            $this->load->view('login_form', $data);
        }
    }

    function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }

    function signup() {
        if ($this->is_logged_in()) {
            redirect('home');
        } else {
            $this->load->view('sign_up_form');
        }
    }

    function seller_signup() {
        if ($this->is_logged_in()) {
            redirect('home');
        } else {
            $this->load->view('seller_sign_up_form');
        }
    }

    function register() {
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
                'label' => 'نام کاربری',
                'rules' => 'required|min_length[6]|max_length[31]'
            ),
            array(
                'field' => 'password',
                'label' => 'رمز عبور',
                'rules' => 'required|min_length[6]|max_length[31]|matches[passconf]'
            ),
            array(
                'field' => 'passconf',
                'label' => 'تکرار رمز عبور',
                'rules' => 'required|min_length[6]|max_length[31]'
            ),
            array(
                'field' => 'email',
                'label' => 'پست الکترونیکی',
                'rules' => 'trim|valid_email|required|min_length[3]|max_length[31]'
            ),
                /*
                  array(
                  'field' => 'phone',
                  'label' => 'شماره‌ی تماس',
                  'rules' => 'trim|required|min_length[3]|max_length[31]'
                  ),

                  array(
                  'field' => 'address',
                  'label' => 'آدرس',
                  'rules' => 'trim|required|min_length[3]|max_length[511]'
                  ),

                  array(
                  'field' => 'seller_display_name',
                  'label' => 'نام شرکت یا فروشگاه',
                  'rules' => 'trim|required|min_length[3]|max_length[63]'
                  ),
                 */
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', '<hr/>وارد کردن %s لازم است.');
        $this->form_validation->set_message('min_length', '<hr/>%s باید حداقل ۶ حرفی باشد.');
        $this->form_validation->set_message('max_length', '<hr/>%s باید حداکثر، ۳۱ حرفی باشد');
        $this->form_validation->set_message('matches', '<hr/> رمز عبور و تکرار آن یکسان نیستند.');
        $this->form_validation->set_message('valid_email', '<hr/>آدرس پست‌الکترونیک وارد شده معتبر نیست.');

        $this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');
        $random_string;
        $pre_text = 'سلام
            درخواست ثبت نام شما در سایت www.serahi.com دریافت گردید. لطفا جهت فعال سازی حساب کاربری خود روی لینک زیر کلیک کنید.
            ';
        $end_text = '
            باتشکر
            ';

        if ($this->form_validation->run() == FALSE) {
            if ($this->input->post('ut') === 'c') {
                $this->signup();
            } elseif ($this->input->post('ut') === 's') {
                $this->seller_signup();
            }
        } else {
            $this->load->model('membership_model');
            if ($this->input->post('ut') === 'c') {
                $user_type = 'customer';
                $random_string = rand_gen(15);
                $insert_query_result = $this->membership_model->insert_member($random_string);
            } elseif ($this->input->post('ut') === 's') {
                $user_type = 'seller';
                $insert_query_result = $this->membership_model->insert_seller($user_type);
            }

            if ($insert_query_result === TRUE) {
                $activation_link = base_url() . 'user/activate?t=' . $random_string;
                $this->load->library('Email_agent');
                $email_to = $this->input->post('email');
                $email_subj = 'Serahi Activation';
                $email_text = $pre_text . $activation_link . $end_text;
                $this->email_agent->send($email_to, $email_subj, $email_text);
                $this->load->view('welcome_new_user');
            } elseif ($insert_query_result == "NOT UNIQUE") {
                $form_data = $this->input->post();
                $error_msg['user_not_unique'] = 'این نام کاربری قبلاً در سیستم ثبت شده است.';

                $this->load->view('sign_up_form', $error_msg);
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }

}