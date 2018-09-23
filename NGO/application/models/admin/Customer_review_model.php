<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_Review_Model extends MY_Model 
{

    public $_table = 'reviews';
    protected $primary_key = 'id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }
  
   /**
    * Get all reviews.
    * 
    * @param  array $condition
    * @return array
    */
    public function get_all_reviews($conditions = array())
    {
        $this->db->select(array('reviews.*', 'customers.first_name', 'customers.last_name', 'order.order_reference'));
        $this->db->from('reviews');
        $this->db->join('customers', 'reviews.customer_id = customers.customer_id');
        $this->db->join('order', 'order.order_id = reviews.order_id');
        $this->db->where(array('reviews.deleted' => 0, 'customers.deleted' => 0));

        return $this->db->get()->result_array();
    }
}
