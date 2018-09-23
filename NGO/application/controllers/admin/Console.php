<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Console extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->template->title('Dashboard');
        
        $this->data['menu'] = 'dashboard';
        $this->data['parent'] = 0;
        $this->data['child'] = 0;

        // Load model
        $this->load->model('public/order_model');
        $this->load->model('admin/reservation_model');
    }

    /**
     * Show the dashboard analytics.
     * 
     * @return void
     */
    public function index() {
        $today = date('Y-m-d');

        $this->data['orders_count_total']   = $this->order_model->getOrdersCount();
        $this->data['orders_count_today']   = $this->order_model->getOrdersCount($today);
        $this->data['sales_total']          = format_currency($this->order_model->getSales());
        $this->data['sales_today']          = format_currency($this->order_model->getSales($today));
        $this->data['reservation_count_total']  = $this->reservation_model->getBookingCount();
        $this->data['reservation_count_today']  = $this->reservation_model->getBookingCount($today);

        $this->template->build('admin/console/index', $this->data);
    }
}
