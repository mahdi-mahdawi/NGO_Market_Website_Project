<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Password extends Frontend_Controller
{
    private $customer_id;

    public function __construct()
    {
        parent::__construct();

        //load library
        $this->load->library('form_validation');
        $this->load->library('bcrypt');
        $this->load->library('auth');

        $this->cms->get_page('account');

        // Load model
        $this->load->model('public/customer_registered_model');

        if (!$this->customer->isLoggedIn()) {
            redirect('login', 'refresh');
            exit();
        }

        $this->customer_id = $this->customer->getCustomerId();

        $this->template->set_partial('profile_menu', 'public/account/sidebar', []);
    }

    /**
     * Customer change password.
     */
    public function index()
    {
        if ($this->input->post('submit') && $this->input->post('submit') == 'CHANGE') {
            $this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required|max_length[255]|callback_check_password');
            $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|max_length[255]|min_length[6]');
            $this->form_validation->set_rules('conf_pass', 'Confirm Password', 'trim|required|matches[new_pass]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                if ($this->customer->updatePassword(array('password' => $this->input->post('new_pass')), $this->customer_id)) {

                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_password_changed')));
                    redirect('account/password');
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                    redirect('account/password');
                }
            }
        }

        $this->data['profile_menu'] = 'password';

        $this->template->build('public/account/password', $this->data);
    }

    /**
     * Customer check old password.
     * 
     * @return boolean.
     */
    public function check_password()
    {
        $result = $this->customer->checkOldpassword($this->input->post('old_pass'), $this->customer_id);

        if (!$result) {
            $this->form_validation->set_message('check_password', 'Check your old password.');

            return false;
        } else {
            return true;
        }
    }
}
