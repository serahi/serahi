<?php

class Transactions_model extends CI_Model {

    function all_transactions($user_id) {
        //$this->db->select('product_id, count ');
        $this->db->where('user_id', $user_id);
        $this->db->where('transactions.product_id = products.id');
        $query = $this->db->get('transactions,products');
        return $query->result_array();
    }

}
