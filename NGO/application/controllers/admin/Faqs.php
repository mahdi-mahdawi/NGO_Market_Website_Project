<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faqs extends Admin_Controller
{
   
    function __construct() 
    {
        parent::__construct();

        $this->data['parent'] = 37;
        $this->data['child'] = 0;

        // Load model
        $this->load->model('admin/faqs_model');

        // Load library
        $this->load->library('form_validation');
    }

   /**
    * Get all customer faqs.
    * 
    * @return void
    */
    public function index() 
    {
        $this->template->load_asset(array('datatable', 'dialog','bootstrap_switch'));
        
        $this->template->title('Faqs');

        $this->data['list'] = $this->faqs_model->get_all();
        
        $this->template->build('admin/faqs/index', $this->data);
    }

   /**
    * Add new faq.
    *
    * @return void
    */
    public function add() 
    {
        if ($this->input->post('submit') && $this->input->post('submit') == 'ADD') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[1000]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $timestamp = date('Y-m-d H:i:s');

                $data = array(
                    'title'         => $this->input->post('title',TRUE),
                    'description'   => $this->input->post('description',TRUE),
                    'status'        => $this->input->post('status',TRUE),
                    'created_at'    => $timestamp,
                    'updated_at'    => $timestamp
                );

                if ($this->faqs_model->insert($data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_faqs_saved')));
                }else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/faqs');
                exit();
            }
        }

        $this->template->title('Add Faqs');
        $this->template->build('admin/faqs/add', $this->data);
    }

   /**
    * Get the FAQ record.
    * 
    * @param  integer $id
    * @return void
    */
    public function edit($id = NULL)
    {
        if (is_null($id) || !is_numeric($id)) {
            show_404();
        }

        $result = $this->faqs_model->as_array()->get_by(array('id' => $id));
        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[1000]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $data = array(
                    'title'         => $this->input->post('title',TRUE),
                    'description'   => $this->input->post('description',TRUE),
                    'status'        => $this->input->post('status',TRUE),
                    'updated_at'    => date('Y-m-d H:i:s')
                );

                if ($this->faqs_model->update($id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_faqs_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/faqs');
                exit();
            }
        }

        $this->data['faqs'] = $result;
        $this->template->title('Edit Faqs');
        
        $this->template->build('admin/faqs/edit', $this->data);
    }

    /**
     * Update the FAQ status.
     * 
     * @return JSON
     */
    public function status_update() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        $id = $this->input->post('id',TRUE);
        $status = $this->input->post('status',TRUE);
        if (empty($id) || empty($status)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->faqs_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->faqs_model->update($id, array('status' => $status))) {
            if ($status) {
                set_ajax_flashdata('success', lang('status_enabled'));
            } else {
                set_ajax_flashdata('success', lang('status_disabled'));
            }
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
    
    /**
     * Delete the FAQ.
     * 
     * @param  integer $id
     * @return JSON
     */
    public function delete($id = NULL) 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($id) || !is_numeric($id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->faqs_model->as_array()->get_by(array('id' => $id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->faqs_model->delete($id)) {
            set_ajax_flashdata('success', lang('success_faqs_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
}
