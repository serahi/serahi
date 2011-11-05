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
			$results[] = array(
					'product_name' => $product->product_name,
					'lower_limit' => $product->lower_limit,
					'sell_count' => $count
			);
		}
		return $results;
	}

}
