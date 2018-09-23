<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends Admin_Controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->data['parent'] = 16;
        $this->data['child'] = 20;

        // Load library
        $this->load->library('form_validation');
        
        // Load model
        $this->load->model('admin/Settings_model');
    }

    /**
     * Update the payment settings.
     * 
     * @return void
     */
    public function index()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('accept_cash', '', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('stripe_payment_status', '', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('checkout_type_delivery', '', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('checkout_type_carryout', '', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('checkout_type_dinein', '', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('stripe_secret_key', '', 'trim');
            $this->form_validation->set_rules('stripe_publishable_key', '', 'trim');

            $this->form_validation->set_rules('braintree_environment', '', 'trim|in_list[production,sandbox]');
            $this->form_validation->set_rules('braintree_merchant_id', '', 'trim');
            $this->form_validation->set_rules('braintree_public_key', '', 'trim');
            $this->form_validation->set_rules('braintree_private_key', '', 'trim');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL,TRUE);

                if($post['stripe']) {
                    $formData['stripe_secret_key']      = $post['stripe_secret_key'];
                    $formData['stripe_publishable_key'] = $post['stripe_publishable_key'];
                }

                else if($post['braintree']) {
                    $formData['braintree_environment']  = $post['braintree_environment'];
                    $formData['braintree_merchant_id']  = $post['braintree_merchant_id'];
                    $formData['braintree_public_key']   = $post['braintree_public_key'];
                    $formData['braintree_private_key']  = $post['braintree_private_key'];
                }

                else {
                    $formData['accept_cash']            = isset($post['accept_cash']) ? 1 : 0;
                    $formData['stripe_payment_status']  = isset($post['stripe_payment_status']) ? 1 : 0;
                    $formData['checkout_type_delivery'] = isset($post['checkout_type_delivery']) ? 1 : 0;
                    $formData['checkout_type_carryout'] = isset($post['checkout_type_carryout']) ? 1 : 0;
                    $formData['checkout_type_dinein']   = isset($post['checkout_type_dinein']) ? 1 : 0;
                    $formData['braintree_payment_status']  = isset($post['braintree_payment_status']) ? 1 : 0;
                }
                
                foreach ($formData as $key => $value) {
                    $this->Settings_model->update_by(array('settings_key' => $key), array('settings_value' => $value));
                }

                $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_payment_updated')));
                
                redirect('admin/settings/payment/' . $tab);
                exit();
            }
        }

        $this->data['settings'] = $this->Settings_model->get_all_settings();
        
        $this->template->build('admin/settings/payment_settings', $this->data);
    }
}
