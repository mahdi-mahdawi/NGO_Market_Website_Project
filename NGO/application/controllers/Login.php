<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        $this->cms->get_page('login');

        // Load library
        $this->load->library('customer');

        if($this->customer->isLoggedIn()) {
            redirect('account', 'refresh');
            exit();
        }
    }

    /**
     * Customer login.
     * 
     * @return void
     */
    public function index() {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('email', 'lang:label.email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'lang:label.password', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL, TRUE);

                // On success
                if ($this->customer->login($post['email'], $post['password'])) {

                    redirect($this->customer->redirectTo());
                    exit();
                }
                
                // On error
                $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_invalid_login')));

                redirect('login', 'refresh');
                exit();
            }
        }

       $this->template->build('public/page/signin');
    }
}