<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review extends Admin_Controller
 {

    function __construct()
    {
        parent::__construct();

        $this->data['parent'] = 39;
        $this->data['child'] = 0;

        $this->template->title('Customer Review');

        // Load library
        $this->load->library('form_validation');

        // Load model
        $this->load->model('admin/customer_review_model');
    }

    /**
     * Get all customer reviews.
     * 
     * @return void
     */
    public function index()
    {
        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
        
        $this->data['list'] = $this->customer_review_model->as_array()->get_all_reviews(array('deleted' => 0));

        $this->template->build('admin/review/index', $this->data);
    }

    /**
     * Get the customer review.
     * 
     * @param  integer $id
     * @return void
     */
    public function edit($id = NULL) 
    {
        if (is_null($id) || !is_numeric($id)) {
            show_404();
        }

        $result = $this->customer_review_model->get($id);
        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('rating', 'Rating', 'trim|required|in_list[1,2,3,4,5]');
            $this->form_validation->set_rules('comment', 'Comments', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $data = array(
                    'rating_value' => $this->input->post('rating',TRUE),
                    'comments' => $this->input->post('comment',TRUE),
                    'status' => $this->input->post('status',TRUE),
                    'date_updated' => date('Y-m-d H:i:s')
                );

                if ($this->customer_review_model->update($id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_review_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/review');
                exit();
            }
        }

        $this->data['review'] = $result;

        $this->template->title('Edit Customer Review');
        $this->template->build('admin/review/edit', $this->data);
    }

    /**
     * Update the customer review status.
     * 
     * @return JSON
     */
    public function status_update() 
    {
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

        $result = $this->customer_review_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->customer_review_model->update($id, array('status' => $status))) {
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
     * Delete the customer review.
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

        $result = $this->customer_review_model->as_array()->get_by(array('id' => $id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->customer_review_model->delete($id)) {
            set_ajax_flashdata('success', lang('success_review_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
}
