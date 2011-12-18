<?php
class Seller extends MY_Controller
{
	function index ()
	{
		$user_id = $this->session->userdata('user_id');
		$this->load->model('seller_model');
		$view_data['products'] = $this->seller_model->get_transaction_summary($user_id);
		$this->load->view('index_view', $view_data);
	}

	function check_pc ()
	{
                    $this->load->view('check_pc');
            
        }
        function check_pursuit_code()
        {
                    $this->load->model('seller_model');
                    $result = $this->seller_model->check_pursuit_code();
                    if($result == True)
                    {
                        if($this->input->post('submit') == "بررسی کن!")
                        {
                            $message['found_pc'] = array('msg' => 'کد رهگیری وارد شده صحیح می‌باشد.');
                            $this->load->view('check_pc', $message);
                        }
                        else
                        {
                            if($this->seller_model->Is_Delivered())
                            {
                                $message['is_delivered'] = array('msg' => 'کالای مورد نظر قبلا تحویل داده شده است.');
                                $this->load->view('check_pc', $message);
                            }
                            else
                            {
                                $this->seller_model->Deliver();
                                $message['delivered'] = array('msg' => 'کالای مورد نظر تحویل داده شد.');
                                $this->load->view('check_pc', $message);
                            }
                        }
                    }
                    elseif($result == False)
                    {
                        $message['not_found_pc'] = array('msg' => 'کد رهگیری وارد شده یافت نشد.');
                        $this->load->view('check_pc', $message);
                    } 
                }

}
