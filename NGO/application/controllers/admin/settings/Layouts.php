<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layouts extends Admin_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->data['parent'] = 16;
        $this->data['child'] = 41;
        
        // Load model.
        $this->load->model('admin/settings_model');

        // Load library.
        $this->load->library('form_validation');
    }

   /**
    * Update the layout settings.
    * 
    * @return void
    */
    public function index()
    {
        
        if ($this->input->post('submit')) {
            
            $keys = ['menu_layout'];
            $this->data['settings'] = $this->settings_model->get_all_settings($keys);
            
            $this->form_validation->set_rules('layouts', 'Layouts', 'trim');
            $this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|required');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                foreach ($this->input->post(NULL,TRUE) as $key => $value) {
                    $update = $this->settings_model->update_by(array('settings_key' => $key), array('settings_value' => $value));
                }

                if ($update) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_layouts_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/settings/layouts');
                exit();
            }
        }

        $this->template->load_asset(array('colorpicker'));
        
        $this->data['settings'] = $this->settings_model->get_all_settings();

        $this->template->build('admin/settings/layouts', $this->data);
    }
}
