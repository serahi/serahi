<?php
class Seller_model extends CI_Model
{
	function get_seller_names ()
	{
		$this->db->select('id, display_name');
		$query = $this->db->get('sellers');
		$data = array();
		foreach ($query->result() as $seller) {
			$data[] = array(
					'id' => $seller->id,
					'display_name' => $seller->display_name
			);
		}
		return $data;
	}
	function get_unapproved_sellers () {
		$this->db->where('approved', 't');
		$query = $this->db->get('sellers');
		//$this->convert()
	}

}
