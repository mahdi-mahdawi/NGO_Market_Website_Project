<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review_Model extends MY_Model {

    public $_table = 'reviews';
    protected $primary_key = 'id';
    protected $soft_delete = TRUE;
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get the review for an order.
     * 
     * @param  string $order_reference
     * @return object
     */
    public function getReview($order_reference) {
        $this->db->select(['reviews.id']);
        $this->db->from('reviews');
        $this->db->join('order', 'order.order_id = reviews.order_id');
        $this->db->where(['order_reference' => $order_reference, 'order.deleted' => 0]);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    /**
     * Get all the reviews.
     * 
     * @return array
     */
    public function getAll() {
        $this->db->select('reviews.comments, reviews.rating_value, reviews.date_created, CONCAT(first_name, " ", last_name) as customer_name');
        $this->db->from('reviews');
        $this->db->join('customers', 'customers.customer_id = reviews.customer_id');
        $this->db->where(['customers.deleted' => 0, 'reviews.deleted' => 0, 'reviews.status' => 1]);
        $this->db->order_by('reviews.id', 'desc');

        return $this->db->get()->result();
    }
}