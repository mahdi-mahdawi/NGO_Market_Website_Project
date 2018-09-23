<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usersms extends Sms {

    function __construct() {
        parent::__construct();

        // Load model
        $this->load->model('public/order_model');
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * New order received.
     * 
     * @param  string $order_reference
     * @return void
     */
    public function orderPlaced($order_reference) {
        $order = $this->order_model->getOrder($order_reference);

        $order = format_order($order);

        if(Settings::get('sms_status_order_placed_to_customer'))
        {
            $this->sendTo($order, Settings::get('sms_template_order_placed_to_customer'), $order['phone']);
        }

        if(Settings::get('sms_status_order_placed_to_admin'))
        {
            $this->sendTo($order, Settings::get('sms_template_order_placed_to_admin'), Settings::get('contact_number'));
        }   
    }

    /**
     * Order confirmed.
     * 
     * @param  string $order_reference
     * @return void
     */
    public function orderConfirmed($order_reference) {
        $order = $this->order_model->getOrder($order_reference);

        $order = format_order($order);

        if(Settings::get('sms_status_order_confirmed_to_customer'))
        {
            $this->sendTo($order, Settings::get('sms_template_order_confirmed_to_customer'), $order['phone']);
        }
    }

    /**
     * Order cancelled.
     * 
     * @param  string $order_reference
     * @return void
     */
    public function orderCancelled($order_reference) {
        $order = $this->order_model->getOrder($order_reference);

        $order = format_order($order);

        if(Settings::get('sms_status_order_cancelled_to_customer'))
        {
            $this->sendTo($order, Settings::get('sms_template_order_cancelled_to_customer'), $order['phone']);
        }
    }

    /**
     * Order delivered.
     * 
     * @param  string $order_reference
     * @return void
     */
    public function orderDelivered($order_reference) {
        $order = $this->order_model->getOrder($order_reference);

        $order = format_order($order);
        
        if(Settings::get('sms_status_order_delivered_to_customer'))
        {
            $this->sendTo($order, Settings::get('sms_template_order_delivered_to_customer'), $order['phone']);
        }
    }
}