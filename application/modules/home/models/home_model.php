<?php

class Home_model extends CI_Model
{

	function get_list ($limit , $page)
	{
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

		$products = $this->db->get('products', $limit , $page);

		$product_array = array();
		foreach ($products->result_array() as $row) {
			$time_str = $row['start_schedule'] . ' ' . $row['start_time'];
			$then = strtotime($row['start_schedule'] . ' ' . $row['start_time']);
			$passed = time() - $then;
			if (($passed <= 0) || ($passed > $row['duration']))
				continue;
                        $sell = $this->db->query('select * from transactions where product_id = '.$row['id'] .
                                ' and (pursuit_code != NULL OR "pursuit_code" != \'canceled\');');
			
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
			$row['remaining'] = $row['duration'] - $passed;
			$product_array[] = $row;
		}
		return $product_array;
	}

	function add_transaction ($pursuit_code)
	{
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('product_id', $this->input->post('product_id'));

		$query_result = $this->db->get('transactions');
		if ($query_result->num_rows() == 0) {
			$transaction_data = array(
					'user_id' => $this->session->userdata('user_id'),
					'product_id' => $this->input->post('product_id'),
					'count' => '1',
					'transaction_time' => date(DATE_FORMAT),
					'buying_state' => 1,
					'pursuit_code ' => $pursuit_code
			);
			$insert_result = $this->db->insert('transactions', $transaction_data);

			$this->db->where('id', $this->input->post('product_id'))->select('lower_limit')->limit(1);
			$q = $this->db->get('products');
			$row = $q->row();
			$lower_limit = $row->lower_limit;
			$this->db->where('product_id', $this->input->post('product_id'))->where('pursuit_code != NULL OR "pursuit_code" != \'canceled\' ');
			$this->db->select('id');
			$q = $this->db->get('transactions');

			if ($q->num_rows >= $lower_limit) {

				return 'sell_actived';
			}

			if ($insert_result == 1)
				return 1;
		} elseif ($query_result->num_rows() == 1) {
			$row = $query_result->row_array();
			if ($row['buying_state'] == 2) {

				$this->db->where('user_id', $this->session->userdata('user_id'))->where('product_id', $this->input->post('product_id'));
				$this->db->set('buying_state', 3)->set('pursuit_code', $pursuit_code);
				$insert_result = $this->db->update('transactions');

				$this->db->where('id', $this->input->post('product_id'))->select('lower_limit')->limit(1);
				$q = $this->db->get('products');
				$row = $q->row();
				$lower_limit = $row->lower_limit;
				$this->db->where('product_id', $this->input->post('product_id'))->where('pursuit_code != NULL OR "pursuit_code" != \'canceled\' ');
				$this->db->select('id');
				$q = $this->db->get('transactions');

				if ($q->num_rows >= $lower_limit) {

					return 'sell_actived';
				}
				if ($insert_result == 1)
					return 2;
			} else {
				return "failed";
			}
		}
	}

	function cancel_transaction ()
	{
		$transaction_data = array(
				'user_id' => $this->session->userdata('user_id'),
				'product_id' => $this->input->post('product_id')
		);
		$this->db->where('user_id', $this->session->userdata('user_id'))->where('product_id', $this->input->post('product_id'));
		$result = $this->db->get('transactions');
		if ($result->num_rows == 1) {
			$row = $result->row_array();
			$this->db->where('product_id', $row['id'])->where('pursuit_code != NULL OR "pursuit_code" != \'canceled\' ');
			$sell = $this->db->get('transactions');
			$sell_count = $sell->num_rows;
			if ($sell_count > $row['lower_limit'])
				return FALSE;
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

	function get_user_trans_info ($product_id)
	{
		$this->db->select('pursuit_code, user_id , email')->where('product_id', $product_id)->from('transactions');
		$this->db->join('customers', 'customers.id = user_id');
		$q = $this->db->get();

		foreach ($q->result() as $row) {
			$message_info[] = array(
					'email' => $row->email,
					'pursuit_code' => $row->pursuit_code
			);
		}
		return $message_info;
	}
        
        function get_news()
        {
            $query = $this->db->get('news');
            return $query->result_array();
        }
}
