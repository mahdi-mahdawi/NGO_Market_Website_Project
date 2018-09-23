<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends Admin_Controller
 {

    function __construct()
    {
        parent::__construct();

        $this->data['parent'] = 24;
        $this->data['child'] = 0;

        $this->template->title('Customer Management');

        // Load library.
        $this->load->library('form_validation');
        $this->load->library('bcrypt');

        // Load model.
        $this->load->model('admin/customer_model');
        
    }

   /**
    * Get all customer data.
    * 
    * @return void
    */
    public function index()
    {
        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
        
        $this->data['list'] = $this->customer_model->get_all_customers(array('customer_type' => 2));

        $this->template->build('admin/customer/index', $this->data);
    }

   /**
    * Get the customer details.
    * 
    * @param  integer $id
    * @return void
    */
    public function edit($id = NULL) 
    {
        if (is_null($id) || !is_numeric($id)) {
            show_404();
        }

       $result = $this->customer_model->get_all_customers(array('customers.customer_id' => $id));

        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[3]|max_length[20]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $data = array(
                    'first_name'    => $this->input->post('first_name',TRUE),
                    'last_name'     => $this->input->post('last_name',TRUE),
                    'zipcode'       => $this->input->post('zipcode',TRUE),
                    'city'          => $this->input->post('city',TRUE),
                    'phone'         => $this->input->post('phone',TRUE),
                    'date_updated'  => date('Y-m-d H:i:s')
                );
                
                $customer_data = [
                    'status'    =>  $this->input->post('status',TRUE)
                ];

                if($this->input->post('password')){
                    $customer_data = [
                        'password' =>  $this->bcrypt->hash_password($this->input->post('password',TRUE))
                    ];
                }
                
                $this->customer_model->update_customer($id, $customer_data);

                if ($this->customer_model->update($id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_customer_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/customer');
                exit();
            }
        }

        $this->data['customer'] = $result;

        $this->template->title('Edit Customer Management');
        
        $this->template->build('admin/customer/edit', $this->data);
    }
    /**
    * Update the customer status.
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

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if (empty($id) || empty($status)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->customer_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->customer_model->update_customer($id, array('status' => $status))) {
            if ($status) {
                set_ajax_flashdata('success', lang('status_enabled'));
            } else {
                set_ajax_flashdata('success', lang('status_disabled'));
            }
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }

    }
}