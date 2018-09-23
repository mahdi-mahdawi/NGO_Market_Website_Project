<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_model extends MY_Model 
{

    public $_table = 'customers';
    protected $primary_key = 'customer_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }
  
   /**
    * Get all customer.
    * @param $conditions array.
    * @return array
    */
    public function get_all_customers($conditions = array())
    {
        $this->db->select(array('customers.*', 'customers_registered.email as email','customers_registered.password as password','customers_registered.status as status'));
        $this->db->from('customers');
        $this->db->join('customers_registered', 'customers.customer_id = customers_registered.customer_id', 'left');
        $this->db->where($conditions);
        
        return $this->db->get()->result_array();
    }

   /**
    * Get particular customer data.
    * @param $conditions integer.
    * @param $data array.
    * @return JSON.
    */
    public function update_customer($conditions,$data)
    {
           $this->db->where('customer_id', $conditions);
           return $this->db->update('customers_registered', $data); 
    }
}
