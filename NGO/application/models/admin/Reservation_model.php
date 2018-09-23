<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Reservation_model extends MY_Model 
{
    public $_table = 'reservations';
    protected $primary_key = 'id';
    protected $soft_delete = TRUE;

    public function __construct() 
    {
        parent::__construct();
    }

   /**
    * Get all reservation.
    * 
    * @param  array $condition
    * @return array
    */
    public function get_all_reservation($conditions = array()) {
 	    $this->db->select('*');
        $this->db->from('reservations');
        $this->db->where(array('reservations.deleted' => 0));
        $this->db->order_by('date_created','asc');

        return $this->db->get()->result_array();
    }

    /**
     * Save the reservation data.
     * 
     * @param  array  $post
     * @return integer
     */
    public function save($post = []) {
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'name'          => $post['name'],
            'email'         => $post['email'],
            'mobile'        => $post['phone'],
            'booking_date'  => $post['booking_date'],
            'booking_time'  => $post['booking_time'],
            'party_size'    => $post['party_size'],
            'extra_notes'   => $post['message'],
            'date_created'  => $timestamp,
            'date_updated'  => $timestamp
        ];

        $this->db->insert('reservations', $data);

        return $this->db->insert_id();
    }

    /**
     * Get the reservation count.
     * 
     * @param  string $date
     * @return integer
     */
    public function getBookingCount($date = null) {
        $this->db->select(['reservations.id']);
        $this->db->from('reservations');
        $this->db->where(['deleted' => 0]);

        if(!is_null($date)) {
            $this->db->where(['DATE(date_created)' => $date]);
        }

        return $this->db->get()->num_rows();
    }
}
