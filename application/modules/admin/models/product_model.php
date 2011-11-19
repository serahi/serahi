<?php

class Product_model extends CI_Model
{

	function insert_product ($product_name, $seller_id, $product_desc,
	                         $base_discount, $product_price, $pic_name,
	                         $lower_limit,$start_schedule, $start_time,
							 $duration)
	{
		$product_data = array(
				'product_name' => $product_name,
				'seller_id' => $seller_id,
				'description' => $product_desc,
				'base_discount' => $base_discount,
				'price' => $product_price,
				'image' => $pic_name,
				'lower_limit' => $lower_limit,
				'start_schedule' => $start_schedule,
				'start_time' => $start_time,
				'duration' => $duration
		);
		$insert_result = $this->db->insert('products', $product_data);
		return $insert_result;
	}
	function get_products ()
	{
		$this->db->select('products.id, product_name, display_name, price, lower_limit, start_schedule, start_time, duration');
		$this->db->where('sellers.id = products.seller_id');
		$query = $this->db->get('products,sellers');
		return $query->result_array();
	}

}
