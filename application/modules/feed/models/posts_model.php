<?php

class Posts_model extends CI_Model{
    function get_posts( $limit = NULL ){
                
        $this->db->order_by('date', 'desc');
        return $this->db->get('posts_rss', $limit );
    }
}