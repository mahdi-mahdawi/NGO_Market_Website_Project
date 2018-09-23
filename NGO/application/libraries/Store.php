<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store {

    /**
     * Tax
     * @var string
     */
    private $tax_amount;

    /**
     * Delivery charge.
     * @var string
     */
    private $delivery_charge;

    /**
     * Sub total.
     * @var string
     */
    private $sub_total;

    /**
     * Grand total.
     * @var string
     */
    private $grand_total;

    /**
     * Checkout type.
     * @var string
     */
    private $checkout_type;

    function __construct() {
        $this->checkout_type = $this->session->userdata('checkout_type');
        $this->sub_total     = $this->cart->total();
    }

    /**
     * Get the tax.
     * 
     * @return string
     */
    public function getTax() {
        return ($this->sub_total) * ((float) Settings::get('tax') / 100);
    }

    /**
     * Get the delivery charge.
     * 
     * @return string
     */
    public function getDeliveryCharge() {
        return ($this->checkout_type == 1) ? Settings::get('delivery_charge') : 0;
    }

    /**
     * Get the subtotal.
     * 
     * @return string
     */
    public function getSubTotal() {
        return $this->sub_total;
    }

    /**
     * Get the grand total.
     * 
     * @return string
     */
    public function getGrandTotal() {
        $grand_total = $this->sub_total + (float) $this->getDeliveryCharge() + (float) $this->getTax();

        $grand_total -= $this->cart->coupon_discount();

        return $grand_total; 
    }

    /**
     * Has the subtotal greater or equal to minimum order amoun ?
     * 
     * @return boolean
     */
    public function hasMinimumOrderAmount() {
        return ($this->sub_total >= Settings::get('minimum_order')) ? 1 : 0;
    }

    /**
     * Get the checkout type.
     * 
     * @return string
     */
    public function getCheckoutType() {
        return $this->checkout_type;
    }

    /**
     * Are we good to proceed to next step ?
     * 
     * @return boolean
     */
    public function allowCheckout() {
        $allow_checkout = 1;

        if(!$this->hasMinimumOrderAmount()) {
            $allow_checkout = 0;
        }else if(!$this->isOpened() && !Settings::get('allow_preorder')){
            $btn_checkout_status = 0;
        }

        if(!$allow_checkout) {
            show_404();
        }

        return true;
    }

    /**
     * Enables the use of CI super-global without having to define an extra variable.
     * 
     * @param string $var
     * @return Instance of CI
     */
    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Get the store working hours.
     * 
     * @return array
     */
    public function openingHours() {
        $days = [
            1   => 'Monday',
            2   => 'Tuesday',
            3   => 'Wednesday',
            4   => 'Thursday',
            5   => 'Friday',
            6   => 'Saturday',
            7   => 'Sunday',
        ];

        $hours = [];

        $result = $this->store_model->get_working_hours();

        foreach($result as $row) {
            $hours[] = [
                'day'           => $days[$row['day']],
                'open_hour'     => date('h:i A', strtotime($row['open_hour'])),
                'close_hour'    => date('h:i A', strtotime($row['close_hour'])),
                'status'        => ($row['status']) ? '<span class="label label-primary">Open</span>' : '<span class="label label-warning">Close</span>',
            ];
        }

        return $hours;
    }

    /**
     * Check the store is opened or closed ?
     * 
     * @return boolean
     */
    public function isOpened() {
        return $this->store_model->is_opened(date('N'), date('H:i'));
    }

    /**
     * Get the active menu layout.
     * 
     * @return string
     */
    public function getMenuLayout() {
        $layout = Settings::get('menu_layout');

        $view = '';

        switch ($layout) {
            case '1':
                $view = 'index-01';
                break;
            
            case '2':
                $view = 'index-02';
                break;

            case '3':
                $view = 'index-03';
                break;
        }

        return $view;
    }
}