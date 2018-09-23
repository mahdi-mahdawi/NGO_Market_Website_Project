<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_Model extends MY_Model {

	public $_table = 'customers';
    protected $primary_key = 'customer_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Signup customer.
     * 
     * @param  array  $form_data
     * @return integer
     */
    public function signupCustomer($data) {
        $customer_id = $this->_signup($data, 2);

        $customer = [
            'email'         => $data['email'],
            'password'      => $data['password'],
            'customer_id'   => $customer_id
        ];

        $this->db->insert('customers_registered', $customer);

        return $customer_id; 	
    }

    /**
     * Signup the guest customers.
     * 
     * @param  array $data
     * @return integer
     */
    public function signupGuest($data) {
        $customer_id = $this->_signup($data, 1);

        $this->db->insert('customers_guest', ['customer_id' => $customer_id]);

        return $customer_id;
    }

    /**
     * Save the customer data.
     * 
     * @param  array $customer
     * @return integer
     */
    private function _signup($customer, $customer_type) {
        $timestamp = date('Y-m-d H:i:s');

        $customer = [
            'first_name'        => $customer['first_name'],
            'last_name'         => $customer['last_name'],
            'city'              => $customer['city'],
            'zipcode'           => $customer['zipcode'],
            'phone'             => $customer['mobile'],
            'date_created'      => $timestamp,
            'date_updated'      => $timestamp,
            'customer_type'     => $customer_type
        ];

        return $this->insert($customer);
    }

    /**
     * Get the customer.
     *
     * @param  array $condition
     * @return array
     */
    public function getCustomer($condition = []) {
        $this->db->select('customers.*, customers_registered.email, customers_registered.password, customers_registered.status');
        $this->db->from('customers');
        $this->db->join('customers_registered', 'customers_registered.customer_id = customers.customer_id');

        if(!empty($condition)) {
            $this->db->where($condition);
        }

        $this->db->where(['customers_registered.deleted' => 0, 'status' => 1]);

        $this->db->limit(0);

        return $this->db->get()->row_array();
    }

    /**
     * Get the customer.
     *
     * @param  array $condition
     * @return array
     */
    public function getCustomerID($condition = []) 
    {
        $this->db->select('*');
        $this->db->from('customers_registered');
        $this->db->where($condition);
        $this->db->where(['customers_registered.deleted' => 0, 'status' => 1]);
        $this->db->limit(0);
 
        return $this->db->get()->row_array();
    }
}