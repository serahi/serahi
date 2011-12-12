<?php
class Seller_model extends CI_Model
{
	function get_transaction_summary ($id)
	{
		$this->db->where('seller_id', $id);
		$query = $this->db->get('products');
		$results = array();
		$products = $query->result();
		foreach ($products as $product) {
			$this->db->where('product_id', $product->id);
			$this->db->from('transactions');
			$count = $this->db->count_all_results();
			$timeline_query = $this->db->query('select extract(hour from transaction_time) * 2 + '.
			                                          'floor(extract(minute from transaction_time) / 30) AS time_id, '.
			                                          'count(*) from transactions '.
												                 'where product_id = ? ' . 
												                 'group by time_id '.
																				 'order by time_id;', array($product->id));
			$timeline_array = $timeline_query->result_array();
			//echo '<pre>'; print_r($timeline_array); echo '</pre>'; //die;
			$timeline = array();
			for ($i=0; $i < count($timeline_array); $i++) {
				$timeline[$timeline_array[$i]['time_id']] = $timeline_array[$i]['count'];
			}
			//echo '<pre>'; print_r($timeline); echo '</pre>'; die;
			$timeline_str = '';
			for ($i=0; $i < 48; $i++) {
				if (!isset($timeline[$i])) {
					$timeline_str .= '0';
				} else {
					$timeline_str .= $timeline[$i];
				}
				if ($i != 47) $timeline_str .= ',';
			}
			$results[] = array(
					'product_name' => $product->product_name,
					'lower_limit' => $product->lower_limit,
					'sell_count' => $count,
					'timeline' => $timeline_str
			);
		}
		return $results;
	}

/* select extract(hour from transaction_time) * 2 + 
         floor(extract(minute from transaction_time) / 30) AS time_id,
         count(*) from transactions
group by time_id;
 */

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
