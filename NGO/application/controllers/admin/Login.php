<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('auth');

        if ($this->auth->logged_in()) {
            redirect(base_url('admin/console'));
            exit();
        }

        $this->template->set_layout('admin_splash');
    }

    public function index() {
        $this->load->library('form_validation');

        if ($this->input->post('submit') && $this->input->post('submit') == 'LOGIN') {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run() == TRUE) {
                if ($this->auth->login($this->input->post('email'), $this->input->post('password'))) {
                    redirect(base_url('admin/console'));
                    exit();
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => config_item('error_invalid_login')));
                    redirect(base_url('admin/login'));
                    exit();
                }
            }
        }

        $this->template->build('admin/login/index', $this->data);
    }

}
