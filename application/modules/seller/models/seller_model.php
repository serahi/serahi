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
