<?php

class News_model extends CI_Model{
    
    function news_list( $id = null ){
        $this->db->order_by('date', 'desc');
        if($id != null){
            $this->db->where('id', $id );
            $query = $this->db->get('news');
            return $query->result_array();
            }
            
        $list = $this->db->get('news');
        return $list->result_array();
        
    }
    
    function add_news(){
        $this->db->insert('news', array(
            'title' => $this->input->post('news_title'),
            'content' => $this->input->post('news_content'),
            'date' => date(DATE_FORMAT)
        ));
    }
    
    function update(){
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('news',array(
            'title' => $this->input->post('news_title'),
            'content' => $this->input->post('news_content')
                ));
    }
    
    function remove(){
        $this->db->where('id' , $this->input->post('news_id'));
        $this->db->delete('news');
    }
}