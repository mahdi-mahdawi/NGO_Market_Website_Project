<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservation extends Admin_Controller
 {

    function __construct()
     {
        parent::__construct();

        $this->data['parent'] = 40;
        $this->data['child'] = 0;

        // Load library.
        $this->load->library('form_validation');
                
        // Load model.
        $this->load->model('admin/reservation_model');
        
        $this->template->title('Reservation management');
    }

   /**
    * Get customer reservation.
    * 
    * @return void
    */
    public function index()
    {
        $this->data['list'] = $this->reservation_model->as_array()->get_all_reservation(array('deleted' => 0));
        
        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));

        $this->template->build('admin/reservation/index', $this->data);
    }

    /**
     * Update the reservation.
     * 
     * @param  int $id
     * @return void
     */
    public function edit($id = NULL)
    {
        if (is_null($id) || !is_numeric($id)) {
            show_404();
        }

        $result = $this->reservation_model->as_array()->get_by(array('id' => $id));
        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
            $this->form_validation->set_rules('booking_date', 'Booking Date', 'trim|required');
            $this->form_validation->set_rules('booking_time', 'Booking Time', 'trim|required');
            $this->form_validation->set_rules('party_size', 'Party Size', 'trim|required');
            $this->form_validation->set_rules('extra_notes', 'Extra Notes', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $data = array(
                    'name' => $this->input->post('name',TRUE),
                    'email' => $this->input->post('email',TRUE),
                    'mobile' => $this->input->post('mobile',TRUE),
                    'booking_date' => $this->input->post('booking_date',TRUE),
                    'booking_time' => $this->input->post('booking_time',TRUE),
                    'party_size' => $this->input->post('party_size',TRUE),
                    'extra_notes' => $this->input->post('extra_notes',TRUE),
                    'status' => $this->input->post('status',TRUE),
                    'date_updated' => date('Y-m-d H:i:s')
                );

                if ($this->reservation_model->update($id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_reservation_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }
                redirect('admin/reservation');
                exit();
            }
        }

        $this->data['reservation'] = $result;
        $this->template->title('Edit reservation management');
        $this->template->load_asset(array('clockpicker', 'datetime-picker'));

        $this->template->build('admin/reservation/edit', $this->data);
    }

    /**
     * Update the reservation status.
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

        $result = $this->reservation_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->reservation_model->update($id, array('status' => $status))) {
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
    * Delete the reservation.
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

        $result = $this->reservation_model->as_array()->get_by(array('id' => $id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->reservation_model->delete($id)) {
            set_ajax_flashdata('success', lang('success_reservation_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
}
