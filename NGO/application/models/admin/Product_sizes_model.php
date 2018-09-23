<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_Sizes_Model extends MY_Model
{
    public $_table = 'product_sizes';
    protected $primary_key = 'id';
           
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all the product szies for a product.
     *
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getAllSizes($condition)
    {
        $this->db->select('product_sizes.id,product_sizes.size_id,product_sizes.price as price,sizes.sizes as sizes');
        $this->db->from('product_sizes');
        $this->db->join('sizes', 'product_sizes.size_id = sizes.id', 'left');
        $this->db->where($condition);

        return $this->db->get()->result();
    }
   
}
