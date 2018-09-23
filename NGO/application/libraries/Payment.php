<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Payment {

    /**
     * Temporary payment token.
     * @var string
     */
    private $foodcart_payment_token;

    /**
     * Current order reference of the payment processing.
     * @var string
     */
    private $order_reference;

    /**
     * Store currency.
     * @var string
     */
    protected $store_currency;

    /**
     * Message from the Gateway.
     * @var string
     */
    protected $message;

    function __construct()
    {
        // Load model
        $this->load->model('public/payment_model');
        $this->load->model('public/order_model');

        // Load library
        $this->load->library('usermailer');
        $this->load->library('usersms');

        $this->store_currency = Settings::get('store_currency');
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Make the transaction.
     * 
     * @return void
     */
    protected function makeTransaction($post, $order) {}

    /**
     * On payment success.
     * 
     * @param  string $order_reference
     * @return void
     */
    public function onSuccess($order_reference = null) 
    {   
        $order_reference = ($order_reference) ?: $this->order_reference;

        // Update the order
        $this->order_model->update_by(['order_reference' => $order_reference], ['order_status' => 1, 'payment_status' => 1]);

        // Update the coupon count
        $this->coupons->incrementUsedCount($this->session->userdata('coupon_id'));

        // Send email
        $this->usermailer->orderPlaced($order_reference);

        // Send sms
        $this->usersms->orderPlaced($order_reference);
    }

    /**
     * On payment error.
     * 
     * @return void
     */
    public function onError($payment_token = null) 
    {   
        $payment_token = ($payment_token) ?: $this->foodcart_payment_token;

        $this->payment_model->delete_by(['token' => $payment_token]);

        exit('Sorry, there was an error processing your payment. Please try again later.');
    }

    /**
     * Get the message from the payment gateway.
     * 
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Set the message from the payment gateway.
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * On payment complete.
     * 
     * @param  string $payment_token
     * @return void
     */
    public function onComplete($payment_token = null) 
    {
        $payment_token = ($payment_token) ?: $this->foodcart_payment_token;

        $this->payment_model->delete_by(['token' => $payment_token]);
    }

    /**
     * Check the payment toke is valid or not ?
     *
     * @param string $payment_token
     * @return string
     */
    public function isValidPaymentToken($payment_token = null) {
        $payment_token = ($payment_token) ?: $this->foodcart_payment_token;

        if(is_null($payment_token)) {
            return false;
        }

        if(empty($order_reference = $this->payment_model->validate_token($payment_token))) {
            return false;
        }

        $this->setOrderReference($order_reference);

        return true;
    }

    /**
     * Set the payment token.
     * 
     * @param string $payment_token
     */
    public function setPaymentToken($payment_token) {
        $this->foodcart_payment_token = $payment_token;
    }

    /**
     * Set the order reference.
     *
     * @param string $order_reference
     */
    public function setOrderReference($order_reference) {
        $this->order_reference = $order_reference;
    }

    /**
     * Get the order reference.
     *
     * @param string $order_reference
     */
    public function getOrderReference() {
        return $this->order_reference;
    }
}
