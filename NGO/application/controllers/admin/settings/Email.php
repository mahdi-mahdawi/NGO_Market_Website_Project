<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends Admin_Controller 
{

    function __construct() {
        parent::__construct();

        $this->data['parent'] = 16;
        $this->data['child'] = 22;

        // Load library.
        $this->load->library('form_validation');

        // Load model.
        $this->load->model('admin/Settings_model');
    }

    /**
     * Get the email settings.
     * 
     * @return void
     */
    public function index() 
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('admin_from_email', 'From Email', 'trim|valid_email');
            $this->form_validation->set_rules('admin_from_name', 'From Name', 'trim');
            $this->form_validation->set_rules('smtp_host', 'Smtp Host', 'trim');
            $this->form_validation->set_rules('smtp_port', 'Smtp Port', 'trim');
            $this->form_validation->set_rules('smtp_username', 'Smtp Username', 'trim');
            $this->form_validation->set_rules('smtp_password', 'Smtp Password', 'trim');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                foreach ($this->input->post() as $key => $value) {
                    $update = $this->Settings_model->update_by(array('settings_key' => $key), array('settings_value' => $value));
                }

                if ($update) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_email_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/settings/email');
                exit();
            }
        }

        $this->data['details'] = $this->Settings_model->get_all_settings();
        
        $this->template->build('admin/settings/email_settings', $this->data);
    }
}
