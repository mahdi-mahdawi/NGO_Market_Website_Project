<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_Queue_Model extends MY_Model {

    public $_table  = 'sms_queue';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Push SMS to database.
     * 
     * @param  array $data
     * @return integer
     */
    public function push($post) {
        $data = [
            'to_number' => $post['to'],
            'body' => $post['body'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('sms_queue', $data);

        return $this->db->insert_id();
    }

    /**
     * Get queued SMS.
     * 
     * @return object
     */
    public function pop() {
        $this->db->select('*');
        $this->db->from('sms_queue');
        $this->db->where(['status' => 0, 'failed' => 0]);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }
}