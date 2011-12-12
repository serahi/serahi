<?php
class Seller_model extends CI_Model
{
	function get_transaction_summary ($id)
	{
		$this->db->where('seller_id', $id);
		$query = $this->db->get('products');
		$results = array();
		$products = $query->result_array();
		foreach ($products as $product) {
			$this->db->where('product_id', $product['id'])->where('buying_state != 2');
			$this->db->from('transactions');
			$count = $this->db->count_all_results();
			$timeline_query = $this->db->query('select extract(hour from transaction_time) * 2 + '.
			                                          'floor(extract(minute from transaction_time) / 30) AS time_id, '.
			                                          'count(*) from transactions '.
												                 'where product_id = ? ' . 
												                 'group by time_id '.
																				 'order by time_id;', array($product['id']));
			$timeline_array = $timeline_query->result_array();
			
			$timeline = array();
			$max = 0;
			for ($i=0; $i < count($timeline_array); $i++) {
				$max = max(array($max, $timeline_array[$i]['time_id']));
				$timeline[$timeline_array[$i]['time_id']] = $timeline_array[$i]['count'];
			}
			//===================================
			
			$time_str = $product['start_schedule'] . ' ' . $product['start_time'];
			$then = strtotime($product['start_schedule'] . ' ' . $product['start_time']);
			$passed = time() - $then;
			if ($passed > $product['duration']) {
				if ($count > $product['lower_limit']) {
					$state = '<span style="color:darkGreen"غیرفعال (به حد نصاب رسیده)</span>';
				} else {
					$state = '<span style="color:red">غیرفعال (به حد نصاب نرسیده)</span>';
				}
			} else {
				$state = '<span style="color:green">فعال</span>';
			}
			
			$now_pos = (int)($passed / 1800);
			$timeline_str = '';
			for ($i=0; $i < min($now_pos + 1, 48); $i++) {
				if (!isset($timeline[$i])) {
					$timeline_str .= '0';
				} else {
					$timeline_str .= $timeline[$i];
				}
				if ($i != min($now_pos, 47)) $timeline_str .= ',';
			}
			
			//===================================
			$results[] = array(
					'product_name' => $product['product_name'],
					'lower_limit' => $product['lower_limit'],
					'sell_count' => $count,
					'timeline' => $timeline_str,
					'state' => $state
			);
		}
		return $results;
	}

	function check_pursuit_code ()
	{
		$this->db->where('pursuit_code', $this->input->post('pursuit_code'));
		$q = $this->db->get('transactions');
		if ($q->num_rows == 0) {
			return False;
		}
		$row = $q->row();
		$product_id = $row->product_id;

		$this->db->where('id', $product_id);
		$this->db->select('seller_id');
		$this->db->limit(1);
		$q = $this->db->get('products');
		$row = $q->row();

		if ($row->seller_id == $this->session->userdata('user_id')) {
			return True;
		}

	}

}
