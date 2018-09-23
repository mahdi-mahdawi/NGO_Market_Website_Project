<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('public/product_model');
    }

    public function index()
    {
        $this->cms->get_page('home');

        $this->data['product_categories'] = $this->product_model->get_all_product_category();
        $this->data['productes'] = $this->product_model->get_featured_product(['is_featured' => 1]);

        $this->template->set_partial('modal_wrapper', 'public/components/modal_body');
        $this->template->build('public/home/index', $this->data);
    }
}
