<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH . 'libraries/Mailer.php';

class Usermailer extends Mailer
{
    
    function __construct() { 
        parent::__construct();

        // Load model
        $this->load->model('public/order_model');
        $this->load->model('public/customer_registered_model');
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Contact us.
     * 
     * @return boolean
     */
    public function contactUs($fromData = []) {
        $data = [
            'name'         => $fromData['name'],
            'email'        => $fromData['email'],
            'phone'        => $fromData['phone'],
            'message'      => $fromData['message']
        ];

        $to         = Settings::get('contact_email');
        $subject    = 'Contact us';
        $view       = 'contact-us';

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * Book your table.
     * 
     * @return boolean
     */
    public function bookTable($fromData = []) {
        $data = [
            'name'         => $fromData['name'],
            'email'        => $fromData['email'],
            'phone'        => $fromData['phone'],
            'booking_date' => $fromData['booking_date'],
            'booking_time' => $fromData['booking_time'],
            'party_size'   => get_party_size($fromData['party_size']),
            'extra_notes'  => $fromData['message']
        ];

        $to         = Settings::get('contact_email');
        $subject    = 'Book table';
        $view       = 'book-table';

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * New order received.
     *
     * @param  string $order_reference
     * @return boolean
     */
    public function orderPlaced($order_reference) {
        $data = transformIndividualOrder($this->order_model->getOrder($order_reference));

        $data['modifier_data'] = transformMail($data);
        $data['checkout_type'] = get_checkout_type_text($data['checkout_type']);
        $data['preorder_text'] = ($data['is_preorder']) ? 'Yes' : 'No';

        $to         = Settings::get('contact_email');
        $subject    = 'New order received.';
        $view       = 'order-placed';

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * Order confirmation email.
     * 
     * @param  string $order_reference
     * @return boolean
     */
    public function orderConfirmed($order_reference) {
        $data = transformIndividualOrder($this->order_model->getOrder($order_reference));
        
        $data['modifier_data'] = transformMail($data);
        $data['checkout_type'] = get_checkout_type_text($data['checkout_type']);

        $to         = $data['email'];
        $subject    = 'Order has been confirmed. #' . $order_reference;
        $view       = 'order-confirmed';

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * Order cancellation email.
     * 
     * @param  string $order_reference
     * @return boolean
     */
    public function orderCancelled($order_reference) {
        $data = $this->order_model->getOrder($order_reference);

        $data['checkout_type'] = get_checkout_type_text($data['checkout_type']);

        $to         = $data['email'];
        $subject    = 'Order has been cancelled. #' . $order_reference;
        $view       = 'order-cancelled';

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * Order delivery email.
     * 
     * @param  string $order_reference
     * @return boolean
     */
    public function orderDelivered($order_reference) {
        $data = $this->order_model->getOrder($order_reference);

        $data['checkout_type'] = get_checkout_type_text($data['checkout_type']);
        $data['order_review_url'] = base_url('reviews/create?review_token=' . encode_order_reference($order_reference));

        $to         = $data['email'];
        $subject    = 'Order has been delivered. #' . $order_reference;
        $view       = 'order-delivered';

        return $this->sendTo($to, $subject, $view, $data); 
    }

    /**
     * Send password reset link.
     *
     * @param integer $customerid.
     * @return boolean.
     */
    public function resetPassword($customerid) 
    {
        $data = $this->customer->getCustomer($customerid);
        $data['password_reset_url'] =base_url('reset-password/' .$data['password_reset_token'] );
        $subject    = 'Reset your password';
        $view       = 'reset-password';

        return $this->sendTo($data['email'], $subject, $view, $data);
    }
}