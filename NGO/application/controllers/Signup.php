<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        $this->cms->get_page('signup');

        // Load library
        $this->load->library('customer');

        if($this->customer->isLoggedIn()) {
            redirect('account', 'refresh');
            exit();
        }
    }

    /**
     * Customer signup.
     * 
     * @return void
     */
    public function index() {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('first_name', 'lang:label.first_name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('last_name', 'lang:label.last_name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('city', 'lang:label.city', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('zipcode', 'lang:label.zipcode', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('email', 'lang:label.email', 'trim|required|valid_email|max_length[255]|callback_is_email_exist');
            $this->form_validation->set_rules('mobile', 'lang:label.phone', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('password', 'lang:label.password', 'trim|required|min_length[6]');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL, TRUE);

                // Save the customer.
                if ($this->customer->signup($post)) {

                    // Auto login
                    if($this->customer->login($post['email'], $post['password'])) {
                        redirect($this->customer->redirectTo());
                        exit();
                    }
                }

                redirect(site_url('signup'), 'refresh');
                exit();
            }
        }

        $this->template->build('public/page/signup');
    }

    /**
     * Check email is already registed.
     * 
     * @param  string  $email
     * @return boolean
     */
    public function is_email_exist($email) {
        if($this->customer->isExist($email)) {
            $this->form_validation->set_message('is_email_exist', 'Email is already registered.');

            return false;
        }

        return true;
    }
}