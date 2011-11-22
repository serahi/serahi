<?php

class Product_model extends CI_Model
{

	function insert_product ($product_name, $seller_id, $product_desc,
	                         $base_discount, $product_price, $pic_name,
	                         $lower_limit,$start_schedule, $start_time,
							 $duration)
	{
		$calendar = cal_from_jd($start_schedule + 0.5, CAL_GREGORIAN);
		$start_schedule = $calendar['date'];
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
	function update_product ($id, $product_name, $seller_id, $product_desc,
	                         $base_discount, $product_price, $pic_name,
	                         $lower_limit,$start_schedule, $start_time,
							 $duration)
	{
		$calendar = cal_from_jd($start_schedule + 0.5, CAL_GREGORIAN);
		$start_schedule = $calendar['date'];
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
		$this->db->where('id', $id);
		$insert_result = $this->db->update('products', $product_data);
		return $insert_result;
	}
	function get_products ()
	{
		$this->db->select('products.id, product_name, display_name, price, base_discount, lower_limit, start_schedule, start_time, duration');
		$this->db->where('sellers.id = products.seller_id');
		$query = $this->db->get('products,sellers');
		$result = $query->result_array();
		for ($i = 0; $i < count($result); $i++) {
			list($year, $month, $day) = explode('-', $result[$i]['start_schedule']);
			$result[$i]['start_schedule'] = gregoriantojd($month, $day, $year);
			$result[$i]['duration'] = ($result[$i]['duration'] / 3600) . ' ساعت';
		}
		return $result;
	}
	function delete_product ($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('products');
	}
	function get_product ($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('products');
		$result = $query->row_array();
			list($year, $month, $day) = explode('-', $result['start_schedule']);
			$result['start_schedule'] = gregoriantojd($month, $day, $year);
		return $result;
	}
}
