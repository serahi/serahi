<?php

class Membership_model extends CI_Model{
    
    function validate_user(){
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        
        $q = $this->db->get('customers');
        
        if($q->num_rows == 1){
          
            foreach($q->result() as $row){
                $name['first_name'] = $row->first_name;
                $name['last_name'] = $row->last_name;
				$name['id'] = $row->id;
            }
            
            return  array(
	    		      	'first_name'=> $name['first_name'],
    	        		'last_name'=> $name['last_name'],
						'id' => $name['id']);
        }
        
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