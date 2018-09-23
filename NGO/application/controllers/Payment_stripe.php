<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Stripe extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        $this->cms->get_page('checkout');

        // Load library
        $this->load->library('payments/stripe');

        // Stripe payment status
        if(Settings::get('stripe_payment_status') == 0) {
           show_404();
        }
    }

    /**
     * Stripe payment form.
     * 
     * @return void
     */
    public function processing() {
        $payment_token = $this->input->get('token');

        $this->stripe->setPaymentToken($payment_token);

        if(!$this->stripe->isValidPaymentToken()) {
            show_404();
        }

        $order_reference = $this->stripe->getOrderReference();

        // Get the Order
        $order = $this->order_model->getOrderWithBillingAddress($order_reference);
        if(empty($order)) {
            show_404();
        }

        // Form submitted.
        if($this->input->post('stripe_token')) {
            $post = $this->input->post(null, true);

            if($this->stripe->makeTransaction($post, $order)) {
                $this->stripe->onComplete();

                redirect('checkout/completed/' .  $order_reference, 'refresh');
                exit();
            }

            else {
                $error = $this->stripe->getMessage();

                $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => $error));

                redirect('payment/stripe?token=' . $payment_token, 'refresh');
                exit();
            }
        }

        $this->data['publishable_key'] = $this->stripe->getPublishableKey();

        $this->template->build('public/checkout/stripe-form', $this->data);
    }
}
