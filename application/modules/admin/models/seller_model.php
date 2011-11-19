<?php
class Seller_model extends CI_Model
{
	function get_seller_names ()
	{
		$this->db->select('id, display_name');
		$query = $this->db->get('sellers');
		return $query->result_array();
	}
	function get_unapproved_sellers () {
		$this->db->where('approved', 'f');
		$query = $this->db->get('sellers');
		return $query->result_array();
	}
        function approve()
        {
            $this->db->where('id', $this->input->post('seller_id') )->
                    set('approved', 'TRUE');
            $this->db->update('sellers');
        }
}
