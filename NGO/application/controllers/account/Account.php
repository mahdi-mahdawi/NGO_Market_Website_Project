<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Account extends Frontend_Controller
{
    private $customer_id;

    public function __construct()
    {
        parent::__construct();

        $this->cms->get_page('account');

        // Load model
        $this->load->model('order_model');
        $this->load->model('public/customer_registered_model');

        if (!$this->customer->isLoggedIn()) {
            redirect('login', 'refresh');
            exit();
        }

        $this->customer_id = $this->customer->getCustomerId();

        $this->template->set_partial('profile_menu', 'public/account/sidebar', []);
    }

    /**
     * Customer profile.
     */
    public function index()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('first_name', 'lang:label.first_name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('last_name', 'lang:label.last_name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('city', 'lang:label.city', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('zipcode', 'lang:label.zipcode', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('mobile', 'lang:label.phone', 'trim|required|max_length[20]');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(null, true);

                if ($this->customer->updateProfile($post)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_profile_update')));
                }

                redirect('account', 'refresh');
                exit();
            }
        }

        $this->data['profile_menu'] = 'profile';

        $this->data['profile'] = $this->customer->getCustomer();

        $this->template->build('public/account/index', $this->data);
    }

    public function logout()
    {
        $this->customer->logout();

        redirect('home', 'refresh');
        exit();
    }
}
