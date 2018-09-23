<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends Frontend_Controller
{
    private $customer_id;

    public function __construct()
    {
        parent::__construct();

        $this->cms->get_page('account');

        // Load model
        $this->load->model('order_model');

        if (!$this->customer->isLoggedIn()) {
            redirect('login', 'refresh');
            exit();
        }

        $this->customer_id = $this->customer->getCustomerId();

        $this->template->set_partial('profile_menu', 'public/account/sidebar', []);
    }

    /**
     * Orders history,.
     */
    public function index()
    {
        $this->data['profile_menu'] = 'orders';

        $this->data['orders'] = $this->order_model->getAllOrders($this->customer_id);

        $this->template->build('public/account/orders', $this->data);
    }

    /**
     * Show the order details.
     *
     * @param string $order_reference
     */
    public function order_details($order_reference = null)
    {
        if (is_null($order_reference)) {
            show_404();
        }

        $this->data['profile_menu'] = 'orders';
        $this->data['order'] = transformIndividualOrder($this->order_model->getOrder($order_reference, $this->customer_id));

        $this->template->build('public/account/order_details', $this->data);
    }
}
