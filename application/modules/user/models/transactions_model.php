<?php

class Transactions_model extends CI_Model {

    function all_transactions($user_id) {
        //$this->db->select('product_id, count ');
        $this->db->where('user_id', $user_id);
        $this->db->where('transactions.product_id = products.id');
        $products = $this->db->get('transactions,products');

        $product_array = array();
        foreach ($products->result_array() as $row) {
            $sell = $this->db->query('select * from transactions where product_id = ' . $row['id'] . ' and buying_state != 2;');
            $sell_count = $sell->num_rows;
            $row['sell_count'] = $sell_count;
            $row['status'] = '';
            if ($row['delivered'] == 't') {
                $row['status'] = 'delivered';
            } else if ($sell_count >= $row['lower_limit']) {
                $row['status'] = 'ready';
            } else {
                $row['status'] = 'low';
            }
            $product_array[] = $row;
        }
        return $product_array;
    }

}
