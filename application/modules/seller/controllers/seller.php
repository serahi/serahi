<?php
class Seller extends MY_Controller
{
	function index ()
	{
		if (!$this->is_seller()) {
			$this->load->view('access_denied');
		} else {
			$user_id = $this->session->userdata('user_id');
			$this->load->model('seller_model');
			$view_data['products'] = $this->seller_model->get_transaction_summary($user_id);
			$this->load->view('index_view', $view_data);
		}
	}

	function is_seller ()
	{
		return ($this->session->userdata('is_logged_in') === TRUE &&
		        $this->session->userdata('user_type') === 'seller');
	}
        
        function check_pc(){
            if (!$this->is_seller()) {
			$this->load->view('access_denied');
		} else {
                    $this->load->view('check_pc');
                }
            
        }
        function check_pursuit_code()
        {
            	if (!$this->is_seller()) {
			$this->load->view('access_denied');
		} else {
                    $this->load->model('seller_model');
                    $result = $this->seller_model->check_pursuit_code();
                    if($result == True)
                    {
                        $message['found_pc'] = array('msg' => 'کد رهگیری وارد شده صحیح می‌باشد.');
                        $this->load->view('check_pc', $message);
                        
                    }elseif ($result == False)
                    {
                        $message['not_found_pc'] = array('msg' => 'کد رهگیری وارد شده یافت نشد.');
                        $this->load->view('check_pc', $message);
                    }
                }
        }

}
