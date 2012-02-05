<?php
class Seller_model extends CI_Model
{
	function get_seller_names ()
	{
		$this->db->select('id, display_name');
		$query = $this->db->get('sellers');
		return $query->result_array();
	}

	function get_approved_sellers ()
	{
		$query = $this->db->select('id, display_name')->where('approved', 't')->get('sellers');
		return $query->result_array();
	}

	function get_unapproved_sellers ($sort, $type)
	{
		$this->db->where('approved', 'f');
		if ($sort == "nothing") {
		} else {
			$this->db->order_by($sort, $type);
		}
		$query = $this->db->get('sellers');
		return $query->result_array();
	}

	function approve ()
	{
		$this->db->where('id', $this->input->post('seller_id'))->set('approved', 'TRUE');
		$this->db->update('sellers');
	}

}
