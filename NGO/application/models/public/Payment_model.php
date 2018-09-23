<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Model extends MY_Model {

    public $_table = 'payment_tokens';
    protected $primary_key = 'id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }

    // Validate the payment token. Token expiry time 30 minutes.
    public function validate_token($token = NULL) {
        $timestamp = date('Y-m-d H:i:s');

        $this->db->select(['order_reference', 'expire_at']);
        $this->db->from('payment_tokens');
        $this->db->where(['token' => $token, 'deleted' => 0]);
        $result = $this->db->get()->row_array();

        // Invalid token
        if(empty($result)) {
            return FALSE;
        }

        // Check token expiry
        if(strtotime($result['expire_at']) - strtotime($timestamp) <= 0) {
            return FALSE;
        }

        return $result['order_reference'];
    }

    // Create token for the payment processing
    public function create_token($data = []) {
        $timestamp = date('Y-m-d H:i:s');

        $data['token']      = create_payment_token();
        $data['created_at'] = $timestamp;
        $data['expire_at']  = date("Y-m-d H:i:s", (strtotime($timestamp) + (60 * 30)));

        if($this->db->insert('payment_tokens', $data)) {
            return $data['token'];
        }

        return FALSE;
    }
}
