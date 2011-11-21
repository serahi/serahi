<?php

class Userlist extends MY_Controller {

    function index() {
        if (_is_admin()) {
            $this->load->model('user_model');
            $view_data['users'] = $this->user_model->get_users();
            $this->load->view('userlist_view', $view_data);
        } else {
            $this->load->view('access_denied');
        }
    }

    function delete() {
        if (_is_admin()) {
            $id = $this->input->post('id');
            $this->load->model('user_model');
            $this->user_model->delete_user($id);
            redirect('admin/userlist');
        } else {
            $this->load->view('access_denied');
        }
    }

    function edit() {
        $user_id = $this->session->userdata('user_id');
        $id = $this->input->get('id');
        if (_is_admin() || $id == $user_id) {
            if ($id) {
                $this->load->model('user_model');
                $user_info = $this->user_model->get_user_info($id);
                if ($user_info === FALSE) {
                    redirect(base_url() . 'admin/userlist');
                }
                $this->load->view('edit_info_view', $user_info);
            } else {
                redirect(base_url() . 'admin/userlist');
            }
        } else {
            $this->load->view('access_denied');
        }
    }

    function save_edit() {
        $user_id = $this->session->userdata('user_id');
        if (_is_admin() || $user_id == $this->input->post('id')) {
            $user = _post_values(array(
                'id',
                'username',
                'password',
                'first_name',
                'last_name',
                'user_type',
                'email'
                    ));
            if ($user['user_type'] == 'seller' && _is_admin()) {
                $user = array_merge($user, _post_values(array(
                            'address',
                            'phone',
                            'display_name',
                            'approved:b'
                        )));
            } else if ($user['user_type'] == 'seller') {
                $user = array_merge($user, _post_values(array(
                            'address',
                            'phone',
                            'display_name'
                        )));
            } else if ($user['user_type'] == 'customer') {
                $user = array_merge($user, _post_values(array(
                            'address',
                            'postal_code',
                            'phone',
                            'birth_date'
                        )));
            }

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
                    'rules' => 'required|min_length[6]|max_length[31]'
                ),
                array(
                    'field' => 'user_type',
                    'label' => 'نوع کاربر',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'email',
                    'label' => 'پست الکترونیکی',
                    'rules' => 'trim|valid_email|required|min_length[3]|max_length[31]'
                ),
                array(
                    'fields' => 'display_name',
                    'label' => 'نام فروشگاه',
                    'rules' => 'required'
                )
            );

            $this->form_validation->set_rules($config);
            $this->form_validation->set_message('required', '<hr/>وارد کردن %s لازم است.');
            $this->form_validation->set_message('min_length', '<hr/>%s باید حداقل ۶ حرفی باشد.');
            $this->form_validation->set_message('max_length', '<hr/>%s باید حداکثر، ۳۱ حرفی باشد');
            $this->form_validation->set_message('matches', '<hr/> رمز عبور و تکرار آن یکسان نیستند.');
            $this->form_validation->set_message('valid_email', '<hr/>آدرس پست‌الکترونیک وارد شده معتبر نیست.');

            $this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');

            if ($this->form_validation->run() == FALSE) {

                $this->load->model('user_model');
                $user_info = $this->user_model->get_user_info($user['id']);
                $user['creation_time'] = $user_info['creation_time'];
                $this->load->view('edit_info_view', $user);
            } else {
                $this->load->model('user_model');
                $this->user_model->edit_user_info($user);
                if (_is_admin()) {
                    redirect(base_url() . "admin/userlist");
                } else {
                    $this->load->view('edit_success_view');
                }
            }
        } else {
            $this->load->view('access_denied');
        }
    }

}
