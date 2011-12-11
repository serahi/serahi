<?php

class Product_model extends CI_Model
{
	function get_product ($id, $user_id)
	{
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
		if (($passed >= 0) && ($passed < $data['duration'])) {
			$sell = $this->db->query('select * from transactions where product_id = '.$data['id'] .
                                ' and (pursuit_code != NULL OR "pursuit_code" != \'canceled\');');
			
      $data['sell_count'] = $sell->num_rows;
			
			$data['remaining'] = $data['duration'] - $passed;
		}
		
		return $data;
	}
}