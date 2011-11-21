<?php

class Home_model extends CI_Model {

    function get_list() {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->select('product_id, buying_state, pursuit_code');
        $user_bought = $this->db->get('transactions');
        $user_bought_array = array();

        foreach ($user_bought->result() as $row) {
            
            $user_bought_array[$row->product_id] = array(
                'buying_state' => $row->buying_state,
                'pursuit_code' => $row->pursuit_code
                    );
        }

        $products = $this->db->get('products');

		$product_array = array();
		foreach ($products->result_array() as $row) {
			$time_str = $row['start_schedule'] . ' ' . $row['start_time'];
			$then = strtotime($row['start_schedule'] . ' ' . $row['start_time']);
			$remain = time() - $then;
			if (($remain <= 0) ||
			    ($remain > $row['duration']))
				continue;
			$this->db->where('product_id', $row['id'])->where('pursuit_code != NULL OR "pursuit_code" != \'canceled\' ');
			$sell = $this->db->get('transactions');
			$sell_count = $sell->num_rows;
			$buying_state = 0;
			$pursuit_code = '';
			if (isset($user_bought_array[$row['id']])) {
				$buying_state = $user_bought_array[$row['id']]['buying_state'];
				$pursuit_code = $user_bought_array[$row['id']]['pursuit_code'];
			}
			$row['pursuit_code'] = $pursuit_code;
			$row['sell_count'] = $sell_count;
			$row['buying_state'] = $buying_state;
			$row['remaining'] = $remain; 
			$product_array[] = $row;
		}
		return $product_array;
    }

    function add_transaction($pursuit_code) {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('product_id', $this->input->post('product_id'));
       
        $query_result = $this->db->get('transactions');
        if ($query_result->num_rows() == 0) {
            $transaction_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'product_id' => $this->input->post('product_id'),
                'count' => '1',
                'transaction_time' => date("Y-m-d H:i:s"),
                'buying_state' => 1,
                'pursuit_code ' => $pursuit_code
            );
            $insert_result = $this->db->insert('transactions', $transaction_data);
            
     
            
            if ($insert_result == 1)
                    return 1;
        } elseif ($query_result->num_rows() == 1) {
            $row = $query_result->row_array();
            if ($row['buying_state'] == 2) {

                $this->db->where('user_id', $this->session->userdata('user_id'))->where('product_id', $this->input->post('product_id'));
                $this->db->set('buying_state', 3)->set('pursuit_code', $pursuit_code);
                $insert_result = $this->db->update('transactions');
                
                $this->db->where('id', $this->input->post('product_id'))->
                select('lower_limit');
                $q = $this->db->get('products');
                $lower_limit = $q.lower_limit;
                $this->db->where('pruduct_id', $this->input->post('product_id'))->
                        where('pursuit_code != NULL OR "pursuit_code" != \'canceled\' ');
                $this->db->select('id');
                $q = $this->db->get('transitions');

                if( $q->num_rows >= $lower_limit )
                {
                    return 'sell_actived';
                }
                if ($insert_result == 1)
                    return 2;
            } else {
                return "failed";
            }
        }
    }

    function cancel_transaction() {
        $transaction_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'product_id' => $this->input->post('product_id')
        );
        $this->db->where('user_id', $this->session->userdata('user_id'))->where('product_id', $this->input->post('product_id'));
        $result = $this->db->get('transactions');
        if ($result->num_rows == 1) {
            $row = $result->row_array();
            if ($row['buying_state'] == 1) {
                $this->db->where('id', $row['id']);
                $this->db->set('buying_state', 2)->set('pursuit_code', 'canceled');
                $this->db->update('transactions');
                return 0;
            } elseif ($row['buying_state'] === 2) {

                return 2;
            } else {
                return "buying_state_is_not_valide";
            }
        } else {
            echo $result->num_rows;
            echo "there are more than one item with the same product_id and user_id";
            echo "user_id= " . $this->session->userdata('user_id') . "<br/>";
            echo "product_id= " . $this->input->post('product_id');
            return 'failed';
        }
    }

}
