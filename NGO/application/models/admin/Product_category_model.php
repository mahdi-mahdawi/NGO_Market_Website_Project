<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_category_model extends MY_Model 
{

    public $_table = 'product_category';
    protected $primary_key = 'product_category_id';
    protected $soft_delete = TRUE;

    public function __construct() 
    {
        parent::__construct();
    }
   
   /**
    * Get all category.
    * @param  integer $condition
    * @return array
    */
    public function get_all_category($conditions = array())
    {
       
        $this->db->select(array('product_category.*'));
        $this->db->from('product_category');
        $this->db->where(array('product_category.deleted' => 0));

        return $this->db->get()->result_array();
    
    }

}
