<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Social_Media extends Admin_Controller 
{

    function __construct() {
        parent::__construct();

        $this->data['parent'] = 16;
        $this->data['child'] = 19;
        
        // Load model.
        $this->load->model('admin/settings_model');

        // Load library.
        $this->load->library('form_validation');
    }

    /**
     * Update the social media settings.
     * 
     * @return void
     */
    public function index()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('url_facebook', 'Facebook Url', 'trim|prep_url');
            $this->form_validation->set_rules('url_twitter', 'Twitter Url', 'trim|prep_url');
            $this->form_validation->set_rules('url_youtube', 'Youtube Url', 'trim|prep_url');
            $this->form_validation->set_rules('url_googleplus', 'Google Plus Url', 'trim|prep_url');
            $this->form_validation->set_rules('url_pinterest', 'Pinterest Url', 'trim|prep_url');
            $this->form_validation->set_rules('url_instagram', 'Instagram Url', 'trim|prep_url');
            
            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                foreach ($this->input->post() as $key => $value) {
                    $update = $this->settings_model->update_by(array('settings_key' => $key), array('settings_value' => $value));
                }

                if ($update) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_social_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/settings/social_media');
                exit();
            }
        }

        $this->data['settings'] = $this->settings_model->get_all_settings();

        $this->template->build('admin/settings/social_settings', $this->data);
    }
}
