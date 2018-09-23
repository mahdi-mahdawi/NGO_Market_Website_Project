<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store extends Admin_Controller 
{

    function __construct() 
    {
        parent::__construct();
        $this->data['parent'] = 16;
        $this->data['child'] = 17;

        // Load model.
        $this->load->model('admin/store_model');
        $this->load->model('admin/currency_model');

        // Load library.
        $this->load->library('form_validation');
    }

    /**
     * Get all store details.
     * 
     * @param string $tab
     * @return void
     */
    public function index($tab = 'basic') 
    {
        if ($tab != 'basic' && $tab != 'contact' && $tab != 'other') {
            show_404();
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('store_name', 'Name', 'trim|max_length[100]');
            $this->form_validation->set_rules('store_banner', 'Store Banner', 'trim|max_length[1000]');

            $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|max_length[1000]');
            $this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|max_length[1000]|valid_email');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|numeric');
            $this->form_validation->set_rules('contact_address', 'Contact Address', 'trim|max_length[1000]');
            $this->form_validation->set_rules('maintenance_mode', 'Maintanence Mode', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('google_analytics', 'Google Analytics', 'trim|max_length[1000]');
            $this->form_validation->set_rules('timezone', 'Time zone', 'trim|max_length[1000]');
            $this->form_validation->set_rules('store_currency', 'Store Currency', 'trim|max_length[10]');
            $this->form_validation->set_rules('currency_code_position', 'Store code position', 'trim|in_list[left,right]');
            $this->form_validation->set_rules('decimal_places', 'Decimal places', 'trim|numeric');
            $this->form_validation->set_rules('use_thousand_seperators', 'Use 1000 Separators', 'in_list[0,1]');
            $this->form_validation->set_rules('thousand_seperators', 'Thousand Separators', 'trim|in_list[Dot,Comma]');
            $this->form_validation->set_rules('decimal_separators', 'Decimal Separators', 'trim|in_list[Dot,Comma]');
            $this->form_validation->set_rules('footer_text', 'Footer text', 'trim|max_length[1000]');
            $this->form_validation->set_rules('facebook_comments_plugin', '', 'trim|max_length[1000]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            // Run the validation.
            if ($this->form_validation->run()) {
                foreach ($this->input->post() as $key => $value) {
                   $update = $this->store_model->update_by(array('settings_key' => $key), array('settings_value' => $value)); 
                }
                
                if($this->input->post('store_currency')!=NULL){   
                    $code=$this->currency_model->as_array()->get_by(array('code' => $this->input->post('store_currency')));
                    $symbol=$this->store_model->update_by(array('settings_key' =>'currency_symbol'), array('settings_value' => $code['symbol']));
                }

                if ($update) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_store_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/settings/store/' . $tab);
                exit();
            }
        }

        $this->data['settings'] = $this->store_model->get_store_settings();
        $this->data['list']     = get_timezones();
        $this->data['language'] = $this->language_model->get_all();
        $this->data['currency'] = $this->currency_model->get_all();
        $this->data['tab']      = $tab;

        $this->template->load_asset(array('jquery_upload', 'select2','dialog', 'editor'));

        // Store banner upload variables.
        $this->data['upload_banner_folder'] = 'cover';
        $this->data['banner_type'] = 'cover';
        $file_id = ($this->input->post('store_banner')) ? $this->input->post('store_banner') : $this->data['settings']['store_banner'];
        $this->data['thumb_banner_image'] = ($this->input->post('store_banner')) ? $this->input->post('store_banner') : $this->data['settings']['store_banner'];
        $this->data['thumb_banner_url'] = ($file_id) ? base_url('uploads/cover/' . $file_id) : base_url('assets/admin/images/thumbnail-default.jpg');
       

        $this->template->build('admin/settings/store_settings', $this->data);
    }
}
