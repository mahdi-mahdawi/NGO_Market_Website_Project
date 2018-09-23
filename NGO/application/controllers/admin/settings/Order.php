<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['parent'] = 16;
        $this->data['child'] = 35;

        // Load library
        $this->load->library('form_validation');
      
        // Load model
        $this->load->model('admin/settings_model');
    }

    /**
     * Update the order settings.
     * 
     * @return void
     */
    public function index()
    {
      
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('minimum_order', 'Minimum Order', 'trim|numeric');
            $this->form_validation->set_rules('tax', 'Tax', 'trim|decimal');
            $this->form_validation->set_rules('delivery_charge', 'Delivery Charges', 'trim|numeric');
            $this->form_validation->set_rules('allow_preorder', 'Pre order', 'trim|required|in_list[0,1]');

            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {

                foreach($this->input->post(NULL, TRUE) as $key => $value) {
                    $this->settings_model->update_by(array('settings_key' => $key), array('settings_value' => $value));
                }

                $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_order_updated')));

                redirect('admin/settings/order');
                exit();
            }
        }

        $keys = ['minimum_order', 'tax', 'delivery_charge', 'delivery_distance', 'allow_preorder'];
        $this->data['settings'] = $this->settings_model->get_all_settings($keys);

        $this->template->build('admin/settings/order_settings', $this->data);
    }
}
