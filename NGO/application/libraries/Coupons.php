<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Coupons
{   

    /**
     * Coupon code.
     * @var string
     */
    private $coupon_code;

    /**
     * Coupon data.
     * @var array
     */
    private $coupon;

    public function __construct()
    {
        // Load model
        $this->load->model('public/coupon_model');
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Apply the coupon.
     * 
     * @param  string $coupon_code
     * @return boolean
     */
    public function apply($coupon_code) {
        $this->coupon_code = $coupon_code;

        $coupon = $this->get($this->coupon_code);
        if(empty($coupon)) {
            return false;
        }

        $this->coupon = $coupon;

        if(!$this->isValid()) {
            return false;
        }

        return $this->cart->apply_coupon($this->coupon);
    }

    /**
     * Remove the applied coupon.
     * 
     * @return boolean
     */
    public function remove() {
        $this->cart->remove_coupon();
    }

    /**
     * Check the coupon is valid or not.
     * 
     * @return boolean
     */
    public function isValid() {
        $today = date('Y-m-d');

        if($this->coupon['status'] == 0) {
            return false;
        }

        if($today < $this->coupon['start_date']) {
            return false;
        }

        if($today > $this->coupon['end_date']) {
            return false;
        }

        if($this->coupon['used_count'] >= $this->coupon['usage_limit']) {
            return false;
        }

        return true;
    }

    /**
     * Get the coupon.
     * 
     * @return array
     */
    public function get() {
        return $this->coupon_model->get_by(['code' => $this->coupon_code]);
    }

    /**
     * Increment the used count of applied coupon.
     * 
     * @return void
     */
    public function incrementUsedCount($coupon_id) {
        $this->coupon_model->incrementUsedCount($coupon_id);
    }
}