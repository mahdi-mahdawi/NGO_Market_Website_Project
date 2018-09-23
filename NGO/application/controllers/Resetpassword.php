<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Resetpassword extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load library
        $this->load->library('form_validation');
        $this->load->library('bcrypt');
        $this->load->library('auth');
        $this->load->library('customer');
        $this->load->library('usermailer');

        // Load model
        $this->load->model('public/customer_registered_model');

        $this->cms->get_page('home');
    }

    /**
     * Customer password reset.
     *
     * @return void.
     */
    public function index()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('email', 'lang:label.email', 'trim|required|valid_email|callback_is_email_exist');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(null, true);

                $result = $this->customer->getCustomerByEmail($post['email']);

                if (!$result) {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                    exit();
                }

                if ($this->customer->createPasswordToken($result['customer_id'])) {
                    $this->usermailer->resetPassword($result['customer_id']);

                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_email_send')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('login', 'refresh');
                exit();
            }
        }

        $this->template->build('public/account/reset_password');
    }

    /**
     * Check email already exist.
     *
     * @param string $email
     *
     * @return bool
     */
    public function is_email_exist($email)
    {
        if (!($this->customer->isExist($email))) {
            $this->form_validation->set_message('is_email_exist', '');
            $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_invalid_email')));

            return false;
        }

        return true;
    }

    /**
     * Customer update new password.
     * 
     * @param string $token.
     */
    public function update($token = null)
    {
        if (is_null($token)) {
            show_404();
        }

        if (!($result = $this->customer->isExistPasswordToken($token))) {
            $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('token_expiry')));
            redirect('login', 'refresh');
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'CHANGE') {
            $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|max_length[255]|min_length[6]');
            $this->form_validation->set_rules('conf_pass', 'Confirm Password', 'trim|required|matches[new_pass]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $data = [
                    'password' => $this->input->post('new_pass'),
                    'password_reset_token' => null,
                    'token_created' => null,
                ];

                if ($this->customer->updatePassword($data, $result['customer_id'])) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_password_changed')));
                    redirect('login', 'refresh');
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                    redirect('login', 'refresh');
                }
            }
        }

        $this->template->build('public/account/update_password');
    }
}
