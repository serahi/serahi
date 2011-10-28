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
        
        $insert_result = $this->db->insert('customers', $user_data);
        return $insert_result;
    }
}