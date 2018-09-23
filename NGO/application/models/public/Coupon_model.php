<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon_Model extends MY_Model
{
    public $_table = 'coupons';
    protected $primary_key = 'id';
    protected $soft_delete = TRUE;

    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Update the coupon used count.
     * 
     * @param  int $coupon_id
     * @return void
     */
    public function incrementUsedCount($coupon_id) {
        $this->db->where('id', $coupon_id);
        $this->db->set('used_count', 'used_count + 1', FALSE);
        $this->db->update('coupons');
    }
}
