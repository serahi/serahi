<?php

class Home_model extends CI_Model {

	function get_list() {

		$this -> db -> where('user_id', $this -> session -> userdata('user_id'));
		$this -> db -> select('product_id');
		$user_bought = $this -> db -> get('transactions');
		$user_bought_array = array();
		
		
		
		foreach ($user_bought->result() as $row) {
			$user_bought_array[] = $row -> product_id;
		}
		
		$products = $this -> db -> get('products');

		$product_array = array();
		foreach ($products->result() as $row) {
			
			$this -> db -> where('product_id', $row->id) ;
			$sell = $this -> db -> get('transactions');
			$sell_count = $sell->num_rows;
			
			$is_bought = FALSE;
			if ( in_array($row->id, $user_bought_array) ){
				$is_bought = TRUE;
				
			}

			$product_array[] = array(
				'id' => $row -> id,
				'product_name' => $row -> product_name,
				'lower_limit' => $row -> lower_limit,
				'description' => $row -> description,
				'image' => $row -> image,
				'base_discount' => $row -> base_discount,
				'price' => $row -> price,
				'is_bought' => $is_bought,
				'sell_count' => $sell_count);
		}
		
		return $product_array;
	}

	function add_transaction() {
		$transaction_data = array('user_id' => $this -> session -> userdata('user_id'), 'product_id' => $this -> input -> post('product_id'), 'count' => '1', 'transaction_time' => date("Y-m-d H:i:s"));
		$insert_result = $this -> db -> insert('transactions', $transaction_data);
		return $insert_result;
	}

}
