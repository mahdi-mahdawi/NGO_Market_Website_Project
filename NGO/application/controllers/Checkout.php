<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Checkout extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('public/order_model');
        $this->load->model('public/customer_model');
        $this->load->model('public/payment_model');

        // Load library
        $this->load->library('store');
        $this->load->library('coupons');
        $this->load->library('usermailer');
        $this->load->library('usersms');

        if (!$this->session->userdata('checkout_type')) {
            $this->session->set_userdata('checkout_type', 1);
        }
    }

    /**
     * Show the checkout form.
     *
     * @return void
     */
    public function index()
    {
        $this->cms->get_page('checkout');

        $sub_total = $this->store->getSubTotal();

        // Cart empty redirect to home.
        if ($sub_total == 0) {
            redirect('home');
            exit();
        }

        $configs = Settings::get(['tax', 'delivery_charge', 'minimum_order', 'checkout_type_dinein', 'checkout_type_carryout', 'checkout_type_delivery', 'accept_cash', 'stripe_payment_status', 'allow_preorder', 'braintree_payment_status']);
        
        extract($configs);

        // Has minimum order amount
        $this->data['has_minimum_order_amount'] = $this->store->hasMinimumOrderAmount();
        $this->data['minimum_order_amount']    = format_currency($minimum_order);

        // Store opening status
        $this->data['is_store_opened']  = $this->store->isOpened();

        // Form submitted.
        if ($this->input->post('confirm') && $this->input->post('confirm') == 'confirm') {
            $this->store->allowCheckout();

            $this->form_validation->set_rules('first_name', 'lang:label.first_name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('last_name', 'lang:label.last_name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('email', 'lang:label.email', 'trim|required|valid_email|max_length[255]');
            $this->form_validation->set_rules('mobile', 'lang:label.phone', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('city', 'lang:label.city', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('zipcode', 'lang:label.zipcode', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('address_line_1', 'lang:label.address_line_1', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('address_line_2', 'lang:label.address_line_2', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('payment_option', '', 'trim|required|in_list[1,2,3]');
            $this->form_validation->set_rules('checkout_types', '', 'trim|required|in_list[1,2,3]');

            if (Settings::get('allow_preorder')) {
                $this->form_validation->set_rules('is_preorder', '', 'trim|required|in_list[0,1]');
            }

            if ($this->input->post('is_preorder') == 1) {
                $this->form_validation->set_rules('preorder_date', 'lang:label.preorder_date', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('preorder_time', 'lang:label.preorder_time', 'trim|required|max_length[255]');
            }

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(null, true);

                $this->processOrder($post);
            }
        }

        if ($checkout_type_delivery) {
            $this->data['checkout_types'][1] = lang('label.delivery');
        }

        if ($checkout_type_carryout) {
            $this->data['checkout_types'][2] = lang('label.carry_out');
        }

        if ($checkout_type_dinein) {
            $this->data['checkout_types'][3] = lang('label.dine_in');
        }

        $this->data['checkout_type']            = $this->store->getCheckoutType();
        $this->data['allow_preorder']           = $allow_preorder;
        $this->data['is_preorder']              = ($this->input->post('is_preorder')) ?: 0;

        if ($this->customer->isLoggedIn()) {
            $this->data['profile'] = $this->customer->getCustomer();
        } else {
            $this->data['profile'] = ['first_name' => '', 'last_name' => '', 'city' => '', 'zipcode' => '', 'email' => '', 'phone' => ''];
        }

        $this->template->set_partial('checkout_form', 'public/checkout/form', []);

        $this->template->build('public/checkout/index', $this->data);
    }

    /**
     * Process the order.
     *
     * @return array
     */
    private function processOrder($post)
    {
        if ($this->customer->isLoggedIn()) {
            $post['guest_checkout']     = 0;
            $post['customer_id']        = $this->customer->getCustomerId();
        } else {
            $post['customer_id']        = $this->customer_model->signupGuest($post);
            $post['guest_checkout']     = 1;
        }

        $post['tax']                = Settings::get('tax');
        $post['tax_amount']         = $this->store->getTax();
        $post['delivery_charge']    = $this->store->getDeliveryCharge();
        $post['subtotal']           = $this->store->getSubTotal();
        $post['payed_amount']       = $this->store->getGrandTotal();
        $post['checkout_type']      = $this->store->getCheckoutType();

        // Coupons
        $post['coupon_id'] = $this->cart->coupon_id();
        $post['coupon_discount'] = $this->cart->coupon_discount();

        $this->session->set_userdata('coupon_id', $post['coupon_id']);

        $post['guest_checkout']     = 1;

        // Cash
        if ($post['payment_option'] == 1) {
            $post['payment_mode']       = 'Cash';
            $post['order_status']       = 1;
            $post['payment_status']     = 1;
        }

        // Card
        elseif ($post['payment_option'] == 2 || $post['payment_option'] == 3) {
            $post['payment_mode']       = 'Card';
            $post['payment_status']     = 0; // Incomplete
            $post['order_status']       = 0; // Incomplete
        }

        // Save the order
        $order_reference = $this->order_model->createOrder($post, $this->cart->contents());

        if ($order_reference) {
            $this->cart->destroy();
        }

        $this->session->set_tempdata('order_reference', $order_reference, 3600);

        if ($post['payment_option'] == 1) {

            // Update the coupon count
            $this->coupons->incrementUsedCount($post['coupon_id']);

            // Send email
            $this->usermailer->orderPlaced($order_reference);

            // Send sms
            $this->usersms->orderPlaced($order_reference);

            redirect('checkout/completed/' .$order_reference);
            exit();
        } elseif ($post['payment_option'] == 2) {
            $payment_token = $this->payment_model->create_token(['order_reference' => $order_reference]);
            if (!$payment_token) {
                show_404();
            }

            redirect('payment/stripe?token=' . $payment_token, 'refresh');
            exit();
        } elseif ($post['payment_option'] == 3) {
            $payment_token = $this->payment_model->create_token(['order_reference' => $order_reference]);
            if (!$payment_token) {
                show_404();
            }

            redirect('payment/braintree?token=' . $payment_token, 'refresh');
            exit();
        }
    }

    /**
     * Show the order summary.
     *
     * @param  string $order_reference
     * @return void
     */
    public function completed($order_reference = null)
    {
        $this->cms->get_page('summary');

        if (is_null($order_reference)) {
            show_404();
        }

        $order_reference_session = $this->session->tempdata('order_reference');
        if ($order_reference_session != $order_reference) {
            redirect('home');
            exit();
        }

        $this->session->unset_userdata('coupon_id');

        $this->data['order'] = transformIndividualOrder($this->order_model->getOrder($order_reference));

        if (empty($this->data['order']['items'])) {
            redirect('home');
            exit();
        }

        $this->template->build('public/checkout/summary', $this->data);
    }

    /**
     * Store the customer chosen checkout type.
     *
     * @return void
     */
    public function type()
    {
        $this->session->set_userdata('checkout_type', $this->input->post('checkout_types'));

        response_json(['status' => 1]);
    }
}
