<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Braintree extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        $this->cms->get_page('checkout');

        // Load library
        $this->load->library('payments/braintree');

        // Braintree payment status
        if(Settings::get('braintree_payment_status') == 0) {
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

        $this->braintree->setPaymentToken($payment_token);

        if(!$this->braintree->isValidPaymentToken()) {
            show_404();
        }

        $order_reference = $this->braintree->getOrderReference();

        // Get the Order
        $order = $this->order_model->getOrderWithBillingAddress($order_reference);
        if(empty($order)) {
            show_404();
        }

        // Form submitted.
        if($this->input->post('submit')) {
            $post = $this->input->post(null, true);

            if($this->braintree->makeTransaction($post, $order)) 
            {
                $this->braintree->onComplete();

                redirect('checkout/completed/' .  $order_reference, 'refresh');
                exit();
            }

            else
            {   
                $error = $this->braintree->getMessage();

                $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => $error));

                redirect('payment/braintree?token=' . $payment_token, 'refresh');
                exit();
            }
        }

        $this->template->build('public/checkout/braintree-form', $this->data);
    }
}