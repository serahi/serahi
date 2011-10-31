<?php

class Product_model extends CI_Model {

    function insert_product($product_name, $seller_id, $product_desc, $base_discount, $product_price, $pic_name, $lower_limit) {
        $product_data = array(
            'product_name' => $product_name,
            'seller_id' => $seller_id,
            'description' => $product_desc,
            'base_discount' => $base_discount,
            'price' => $product_price,
            'image' => $pic_name,
            'lower_limit' => $lower_limit
        );
        $insert_result = $this->db->insert('products', $product_data);
        return $insert_result;
    }

}
