<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SMS extends Admin_Controller
{

    function __construct() {
        parent::__construct();

        $this->data['parent'] = 16;
        $this->data['child'] = 36;
        
        // Load library.
        $this->load->library('form_validation');
    
        // Load model.
        $this->load->model('admin/settings_model');

        $this->form_validation->set_message('required', 'This field is required');
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
    }
    
    /**
     * Update the sms settings.
     * 
     * @return void
     */
    public function index()
    {
     
        if ($this->input->post('submit')) {
            $action = $this->input->post('submit');

            if($action == 'sms_gateway') {
                $this->_settings_sms_gateway();
            }
            
            else if($action == 'settings_twilio') {
                $this->_settings_twilio();
            }

            else if($action == 'settings_nexmo') {
                $this->_settings_nexmo();
            }

            else if($action == 'settings_clickatell') {
                $this->_settings_clickatell();
            }

            else if($action == 'sms_templates') {
                $this->_settings_sms_templates();
            }

            else if($action == 'sms_status') {
                $this->_settings_sms_status();
            }

            else {
                show_404();
            }
            
            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL, TRUE);

                // SMS status
                if($action == 'sms_status') {
                    $post = [
                        'sms_status_order_placed_to_admin'        => isset($post['sms_status_order_placed_to_admin']) ? 1 : 0,
                        'sms_status_order_placed_to_customer'     => isset($post['sms_status_order_placed_to_customer']) ? 1 : 0,
                        'sms_status_order_confirmed_to_customer'  => isset($post['sms_status_order_confirmed_to_customer']) ? 1 : 0,
                        'sms_status_order_cancelled_to_customer'  => isset($post['sms_status_order_cancelled_to_customer']) ? 1 : 0,
                        'sms_status_order_delivered_to_customer'  => isset($post['sms_status_order_delivered_to_customer']) ? 1 : 0,
                    ];
                }

                foreach ($post as $key => $value) {
                    $this->settings_model->update_by(array('settings_key' => $key), array('settings_value' => $value));
                }
            
                $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_sms_updated')));
                
                redirect('admin/settings/SMS');
                exit();
            }
        }
        
        $this->data['settings'] = $this->settings_model->get_all_settings();
        
        $this->template->build('admin/settings/sms_settings', $this->data);
    }

    private function _settings_sms_gateway() {
        $this->form_validation->set_rules('sms_gateway', '', 'trim|required|in_list[twilio,nexmo,clickatell]');
    }

    private function _settings_twilio() {
        $this->form_validation->set_rules('twilio_account_id', '', 'trim|required');
        $this->form_validation->set_rules('twilio_auth_token', '', 'trim|required');
        $this->form_validation->set_rules('twilio_from_number', '', 'trim|required');
    }

    private function _settings_nexmo() {
        $this->form_validation->set_rules('nexmo_api_key', '', 'trim|required');
        $this->form_validation->set_rules('nexmo_api_secret', '', 'trim|required');
        $this->form_validation->set_rules('nexmo_from_number', '', 'trim|required');
    }

    private function _settings_clickatell() {
        $this->form_validation->set_rules('clickatell_username', '', 'trim|required');
        $this->form_validation->set_rules('clickatell_password', '', 'trim|required');
        $this->form_validation->set_rules('clickatell_api_key', '', 'trim|required');
        $this->form_validation->set_rules('clickatell_from_number', '', 'trim|required');
    }

    private function _settings_sms_templates() {
        $this->form_validation->set_rules('sms_template_order_placed_to_admin', '', 'trim|max_length[255]');
        $this->form_validation->set_rules('sms_template_order_placed_to_customer', '', 'trim|max_length[255]');
        $this->form_validation->set_rules('sms_template_order_confirmed_to_customer', '', 'trim|max_length[255]');
        $this->form_validation->set_rules('sms_template_order_cancelled_to_customer', '', 'trim|max_length[255]');
        $this->form_validation->set_rules('sms_template_order_delivered_to_customer', '', 'trim|max_length[255]');
    }

    private function _settings_sms_status() {
       $this->form_validation->set_rules('sms_status_order_placed_to_admin', '', 'trim');
       $this->form_validation->set_rules('sms_status_order_placed_to_customer', '', 'trim');
       $this->form_validation->set_rules('sms_status_order_confirmed_to_customer', '', 'trim');
       $this->form_validation->set_rules('sms_status_order_cancelled_to_customer', '', 'trim');
       $this->form_validation->set_rules('sms_status_order_delivered_to_customer', '', 'trim');
    }
}