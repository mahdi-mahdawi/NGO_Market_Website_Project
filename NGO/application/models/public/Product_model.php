<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all the active productes.
     * 
     * @return array
     */
    public function get_all_product($conditions = array()) {
        $this->db->select(array('product.product_id', 'product.name', 'product.url_slug', 'product.description', 'product.price', 'product.image', 'product_category.name as category_name', 'product.product_category_id', 'product.product_type_id', 'product_category.url_slug as product_category_url_slug','product_sizes.size_id as size_id','product_sizes.price as menu_price','sizes.sizes as size'));
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.product_category_id = product.product_category_id');
        $this->db->join('product_sizes', 'product_sizes.product_id = product.product_id','left');
        $this->db->join('sizes', 'product_sizes.size_id = sizes.id','left');
        $this->db->where(array('product.status' => 1, 'product.deleted' => 0, 'product_category.status' => 1, 'product_category.deleted' => 0));

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        $this->db->order_by('product_category.name');
        $this->db->order_by('product.name');

        return $this->db->get()->result_array();
    }

 

    /**
     * Get a product details.
     * 
     * @return array
     */
    public function get_product($conditions = array()) {
        $this->db->select(array('product.product_id', 'product.name', 'product.url_slug', 'product.description', 'product.price', 'product.image', 'product.product_id', 'product_category.name as category_name', 'product.product_category_id','product_category.url_slug as product_category_url_slug', 'product.product_type_id','product_sizes.size_id as size_id','product_sizes.price as menu_price','sizes.sizes as size'));
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.product_category_id = product.product_category_id');
        $this->db->join('product_sizes', 'product_sizes.product_id = product.product_id','left');
        $this->db->join('sizes', 'product_sizes.size_id = sizes.id','left');
        
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        $this->db->where(array('product.status' => 1, 'product.deleted' => 0, 'product_category.status' => 1, 'product_category.deleted' => 0));

        return $this->db->get()->result_array();
    }

    /**
     * Get all product categories.
     * 
     * @return array
     */
    public function get_all_product_category($conditions = array()) {
        $this->db->select(array('product_category.product_category_id', 'product_category.name', 'product_category.url_slug', 'product_category.description', 'product_category.image'));
        $this->db->from('product_category');

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        $this->db->where(['product_category.deleted' => 0, 'product_category.status' => 1]);
        $this->db->order_by('product_category.name');

        return $this->db->get()->result_array();
    }

    /**
     * Get the related productes - productes from the same category.
     * 
     * @param  integer $product_category_id
     * @return array
     */
    public function get_related_productes($product_category_id, $chosen_product_id) {
        $this->db->select(array('product.product_id', 'product.name', 'product.url_slug', 'product.price', 'product.image'));
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.product_category_id = product.product_category_id');
        $this->db->where(array('product.status' => 1, 'product.deleted' => 0, 'product_category.status' => 1, 'product_category.deleted' => 0, 'product.product_category_id' => $product_category_id, 'product_id !=' => $chosen_product_id));
        $this->db->limit(4);
        $this->db->order_by('rand()');

        return $this->db->get()->result_array();
    }

    /**
     * Get all the featured productes.
     * 
     * @return array
     */
    public function get_featured_product($conditions = array()) {
        $this->db->select(array('product.product_id', 'product.name', 'product.url_slug', 'product.description', 'product.price', 'product.image', 'product_category.name as category_name', 'product.product_category_id', 'product.product_type_id', 'product_category.url_slug as product_category_url_slug'));
        $this->db->from('product');
        $this->db->join('product_category', 'product_category.product_category_id = product.product_category_id');
        $this->db->where(array('product.status' => 1, 'product.deleted' => 0, 'product_category.status' => 1, 'product_category.deleted' => 0));

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        $this->db->order_by('product_category.name');
        $this->db->order_by('product.name');

        return $this->db->get()->result_array();
    }
}
