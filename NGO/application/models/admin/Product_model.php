<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends MY_Model
{

    public $_table = 'product';
    protected $primary_key = 'product_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all the product items.
     * 
     * @param  array  $conditions
     * @return void
     */
    public function get_all_product($conditions = array()) 
    {
        $this->db->select('product.*, product_category.name as category_name');
        $this->db->from('product');
        $this->db->join('product_category', 'product.product_category_id = product_category.product_category_id');
        $this->db->where(['product_category.deleted' => 0, 'product.deleted' => 0]);

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        return $this->db->get()->result_array();
    }
}
