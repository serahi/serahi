<?php

class User extends MY_Controller {

    var $data;

    function __construct() {
        parent::__construct();
        $this->lang->load('user', 'farsi');
    }

    function login() {
    	//redirect: home
    	//access level: unregistered
        $this->load->view('login_form');
    }

    function login_check() {

    	//redirect: home
    	//access level: unregistered
        $this->load->model('membership_model');
        $name = $this->membership_model->validate_user();
        if ($name !== FALSE) {
            if ($name == 'not_approved') {
                $message['not_approved_msg'] = array('msg' => "عضویت شما هنوز توسط مدیر سایت تائید نشده است.");
                $this->load->view('login_form', $message);
                return;
            }
            $user_session_data = array(
                'username' => $this->input->post('username'),
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'user_id' => $name['id'],
                'user_type' => $name['user_type'],
                'email' => $name['email'],
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

    function signup() {
    	//redirect: home
    	//access level: unregistered
            $this->load->view('sign_up_form');
    }

    function seller_signup() {
    	//redirect: home
    	//access level: unregistered
            $this->load->view('seller_sign_up_form');
    }

    function register() {
    	$this->load->library('validator');
			$validated = $this->validator->validate(array(
				'first_name',
				'last_name',
				'username',
				'password',
				'password_confirm',
				'email'
			));
        $random_string;
        $pre_text = 'سلام
            درخواست ثبت نام شما در سایت www.serahi.com دریافت گردید. لطفا جهت فعال سازی حساب کاربری خود روی لینک زیر کلیک کنید.
            ';
        $end_text = '
            باتشکر
            ';

        if ($validated == FALSE) {
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
                if ($this->input->post('ut') === 'c') {
                    $activation_link = base_url() . 'user/activate?t=' . $random_string;
                    $this->load->library('Email_agent');
                    $email_to = $this->input->post('email');
                    $email_subj = 'Serahi Activation';
                    $email_text = $pre_text . $activation_link . $end_text;
                    @$this->email_agent->send($email_to, $email_subj, $email_text);
                    //exec("/usr/bin/php5 /var/www/serahi/send_mail.php")
                    $this->load->view('welcome_new_user', array('activation_link' => $activation_link));
                } elseif ($this->input->post('ut') === 's') {
                    $this->load->view('welcome_seller');
                }
            } elseif ($insert_query_result == "NOT UNIQUE") {
                if($this->input->post('ut') === 'c'){
                    $form_data = $this->input->post();
                    $error_msg['user_not_unique'] = 'این نام کاربری قبلاً در سیستم ثبت شده است.';
                    $this->load->view('sign_up_form', $error_msg);
                }elseif($this->input->post('ut') === 's'){
                    $form_data = $this->input->post();
                    $error_msg['user_not_unique'] = 'این نام کاربری قبلاً در سیستم ثبت شده است.';
                    $this->load->view('seller_sign_up_form', $error_msg);
                }
            }
        }
    }

    function activate() {
            $code = $_GET["t"];
            $this->load->model('membership_model');
            $query_result = $this->membership_model->validate_activation_code($code);
            if ($query_result === NULL) {
                $this->load->view('access_denied');
            } else {
                $data = array(
                    'user_id' => $query_result
                );
                $this->load->view('sign_up_part2', $data);
            }
    }

    function complete_registration() {
        $choice = $this->input->post("submit");
        $this->load->model('membership_model');
        $user_id = $this->input->post('user_id');
        if ($choice == "گذر") {
            $this->membership_model->activate($user_id);

            $name = $this->membership_model->auto_login($user_id);
            $user_session_data = array(
                'username' => $this->input->post('username'),
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'user_id' => $name['id'],
                'user_type' => $name['user_type'],
                'email' => $name['email'],
                'is_logged_in' => TRUE
            );
            $this->session->set_userdata($user_session_data);

            redirect('home');
        } else if ($choice == "ارسال") {
            $this->membership_model->update_on_activation($user_id);

            $name = $this->membership_model->auto_login($user_id);
            $user_session_data = array(
                'username' => $this->input->post('username'),
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'user_id' => $name['id'],
                'user_type' => $name['user_type'],
                'email' => $name['email'],
                'is_logged_in' => TRUE
            );
            $this->session->set_userdata($user_session_data);

            redirect('home');
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }

}

