<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Working_hours extends Admin_Controller 
{

    function __construct() 
    {
        parent::__construct();
        $this->data['parent'] = 16;
        $this->data['child'] = 18;

        //Load model.
        $this->load->model('admin/working_hours_model');
        $this->load->library('form_validation');
    }

    public function index() 
    {

    
        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $close_hour = $this->input->post('close_hour');
            foreach ($this->input->post('open_hour') as $key => $row):
                if (strtotime($row) > strtotime($close_hour[$key])) {
                    $this->form_validation->set_rules('open_hour[' . $key . ']', 'Open Hour', 'trim|greater_than');
                    $this->form_validation->set_rules('close_hour[' . $key . ']', 'Close Hour', 'trim|greater_than');
                } else {
                    $this->form_validation->set_rules('open_hour[' . $key . ']', 'Open Hour', 'trim');
                    $this->form_validation->set_rules('close_hour[' . $key . ']', 'Close Hour', 'trim');
                }
            endforeach;
        
            $this->form_validation->set_message('greater_than', lang('error_message_time'));
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run() == TRUE) {
                if ($this->working_hours_model->update_time($this->input->post())) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_working_hours_saved')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }
        
                redirect('admin/settings/working_hours');
                exit();
            }
        }

        //load data
        $this->data['days'] = $this->working_hours_model->as_array()->get_all();

        $this->template->load_asset(array('clockpicker'));

        $this->template->build('admin/settings/working_hours', $this->data);
    }
}
