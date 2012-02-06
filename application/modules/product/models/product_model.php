<?php

class Product_model extends CI_Model {

    function get_product($id, $user_id) {
        $query = $this->db->where('id', $id)->get('products');
        $data = $query->row_array();
        $query = $this->db->where('id', $data['seller_id'])->get('sellers');
        $seller = $query->row_array();
        $data['map_location'] = $seller['map_location'];
        $data['seller_display_name'] = $seller['display_name'];
        $query = $this->db->select('buying_state, pursuit_code')
                        ->where('product_id', $id)->where('user_id', $user_id)->get('transactions');
        if ($query->num_rows > 0) {
            $result = $query->row_array();
            $data['buying_state'] = $result['buying_state'];
            $data['pursuit_code'] = $result['pursuit_code'];
        } else {
            $data['buying_state'] = 0;
            $data['pursuit_code'] = '';
        }

        $time_str = $data['start_schedule'] . ' ' . $data['start_time'];
        $then = strtotime($data['start_schedule'] . ' ' . $data['start_time']);
        $passed = time() - $then;
            $sell = $this->db->query('select * from transactions where product_id = ' . $data['id'] .
                    ' and (pursuit_code != NULL OR "pursuit_code" != \'canceled\');');

            $data['sell_count'] = $sell->num_rows;
        if (($passed >= 0) && ($passed < $data['duration'])) {

            $data['remaining'] = $data['duration'] - $passed;
        }

        return $data;
    }

    //no comment?!
    function get_comments($product_id) {
        $this->db->where('product_id', $product_id);
        $this->db->select('*');
        $this->db->from('comments');
        $this->db->join('users', 'users.id = comments.user_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_limited_comments($product_id,$limit , $page) {
    	$comment = array();
        $product = $this->db->where('id', $product_id)->get('products');
        foreach ($product->result() as $row) {
            $seller=$row->seller_id;
        }
        $this->db->where('product_id', $product_id);
        $this->db->select('*');
        $this->db->join('users', 'users.id = comments.user_id');
        $query = $this->db->get('comments',$limit , $page);                
        foreach ($query->result() as $row) {
            if ($row->user_id==$seller) {   
            $comment[] = array(
                    'username' => $row->username,
                    'date' => $row->date,
                    'content' => $row->content,
                    'seller' => true
                );
            } else {
                $comment[] = array(
                    'username' => $row->username,
                    'date' => $row->date,
                    'content' => $row->content,
                    'seller' => false
                );
            }//end of else
        }//end of foreach
        return $comment;
    }
    
    function add_comment($user_id) {
        $this->db->insert('comments', array(
            'user_id' => $user_id,
            'content' => $this->input->post('comment_content'),
            'date' => date(DATE_FORMAT),
            'product_id'=> $this->input->post('product_id')
        ));
    }

    //not ready yet
    //led?!
    function edit_comment() {
        $this->db->where('id', $this->input->post('comment_id'));
        $this->db->update('comments', array(
            'content' => $this->input->post('comment_content')
        ));
    }

    //not ready yet
    function remove_comment() {
        $this->db->where('id', $this->input->post('comment_id'));
        $this->db->delete('comments');
    }

}
