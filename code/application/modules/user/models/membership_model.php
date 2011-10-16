<?php

class Membership_model extends CI_Model{
    
    function validate_user(){
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', $this->input->post('password'));
        
        $q = $this->db->get('users');
        
        if($q->num_rows == 1){
            //print_r($q->result());die();
            foreach($q->result() as $row){
                $name['first_name'] = $row->first_name;
                $name['last_name'] = $row->last_name;
            }
            
            return  array('first_name'=> $name['first_name'],'last_name'=> $name['last_name']);
        }
        
    }
    
    function insert_member(){
        $user_data = array(
          'first_name' => $this->input->post('first_name'),
          'last_name' => $this->input->post('last_name'),
          'username' => $this->input->post('username'),
          'password' => md5($this->input->post('password')),
          'email' => $this->input->post('email'),
          'postal_code' => $this->input->post('postal_code'),
          'state' => $this->input->post('state'),
          'city' => $this->input->post('city'),
          'address' => $this->input->post('address')
        );
        
        $insert_result = $this->db->insert('users', $user_data);
        return $insert_result;
    }
}