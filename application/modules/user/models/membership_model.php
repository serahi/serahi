<?php

class Membership_model extends CI_Model{
    
    function validate_user(){
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        
        $q = $this->db->get('users');
        
        if($q->num_rows == 1){
        	$user = $q->row();
					return array(
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'id' => $user->id,
						'user_type' => $user->user_type
					);
        }
				return NULL;
    }
    
    function insert_member(){
        $user_data = array(
          'first_name' => $this->input->post('first_name'),
          'last_name' => $this->input->post('last_name'),
          'username' => $this->input->post('username'),
          'password' => md5($this->input->post('password')),
          'email' => $this->input->post('email'),
        );
		$this->db->where('username', $this->input->post('username'));
		$q = $this->db->get('users');
		if ($q->num_rows >= 1){
			return "NOT UNIQUE";
		}else{
        	$insert_result = $this->db->insert('customers', $user_data);
        	return $insert_result;
		}
    }
	
	function insert_seller($user_type){
		$user_data = array(
		'first_name' => $this->input->post('first_name'),
          'last_name' => $this->input->post('last_name'),
          'username' => $this->input->post('username'),
          'password' => md5($this->input->post('password')),
          'email' => $this->input->post('email'),
          'display_name' => $this->input->post('seller_display_name'),
          'address' => $this->input->post('address'),
          'phone' => $this->input->post('phone'),
          'user_type' => $user_type,
          'creation_time' => date("Y-m-d H:i:s")
          
		);
		
		$this->db->where('username', $this->input->post('username'));
		$q = $this->db->get('users');
		if ($q->num_rows >= 1){
			return "NOT UNIQUE";
		}else{
        	$insert_result = $this->db->insert('sellers', $user_data);
        	return $insert_result;
		}
		
	}
}