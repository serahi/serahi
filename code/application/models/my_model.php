<?php

class My_model extends CI_Model{
    
    function get_students() {
        $q = $this->db->get('students');

        
        return $q->result();
    }
}
?>