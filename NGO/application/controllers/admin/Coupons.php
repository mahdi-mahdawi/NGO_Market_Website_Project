<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupons extends Admin_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->data['parent'] = 23;
        $this->data['child'] = 0;
        
        $this->load->model('admin/coupon_model');

        $this->template->title('Coupons');
        $this->template->load_asset(array('datetime-picker'));

        $this->load->library('form_validation');
    
    }

    /**
     * Get coupons.
     * 
     * @return void
     */
    public function index() 
    {
        $this->data['list'] = $this->coupon_model->get_all();

        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
        $this->template->build('admin/coupons/index', $this->data);
    }

    /**
     * Add coupons.
     * 
     * @return void
     */
    public function add() 
    {
        if ($this->input->post('submit')  && $this->input->post('submit') == 'ADD') {
            $this->form_validation->set_rules('code', 'Coupon code', 'trim|required|max_length[10]|alpha_numeric|is_unique[coupons.code]');
            $this->form_validation->set_rules('discount_type', 'discount type', 'trim|required|in_list[percentage,fixed_amount]');

            if ($this->input->post('discount_type') == 'percentage') {
                $this->form_validation->set_rules('discount', 'Discount', 'trim|numeric|required|callback_valid_percentage');
            } else {
                $this->form_validation->set_rules('discount', 'Discount', 'trim|numeric|required');
            }

            $this->form_validation->set_rules('usage_limit', ' Usage limit', 'trim|numeric|required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|in_list[0,1]');
                       
            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $timestamp = date('Y-m-d H:i:s');

                $data = array(
                    'code'              => $this->input->post('code',TRUE),
                    'discount_type'     => $this->input->post('discount_type', TRUE),
                    'discount'          => $this->input->post('discount',TRUE),
                    'start_date'        => date("Y-m-d", strtotime($this->input->post('start_date',TRUE))),
                    'end_date'          => date("Y-m-d", strtotime($this->input->post('end_date',TRUE))),
                    'usage_limit'       => $this->input->post('usage_limit',TRUE),
                    'status'            => $this->input->post('status',TRUE),
                    'date_created'      => $timestamp,
                    'date_updated'      => $timestamp
                );
          
                if ($this->coupon_model->insert($data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_coupons_added')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/coupons');
                exit();
            }
        }
        
        $this->template->build('admin/coupons/add', $this->data);
    }

   /**
    * Edit coupons.
    * 
    * @param integer $coupon_id
    * @return void
    */
    public function edit($coupon_id = NULL) 
    {
        if (is_null($coupon_id) || !is_numeric($coupon_id)) {
            show_404();
        }

        $result = $this->coupon_model->get_by(array('deleted' => 0, 'id' => $coupon_id));
        if (empty($result)) {
            show_404();
        }
       
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('code', 'Coupon code', 'trim|required|max_length[10]|alpha_numeric');
            $this->form_validation->set_rules('discount_type', 'type', 'trim|max_length[100]|required|in_list[percentage,fixed_amount]');

            if ($this->input->post('discount_type') == 'percentage') {
                $this->form_validation->set_rules('discount', 'Discount', 'trim|numeric|required|callback_valid_percentage');
            } else {
               $this->form_validation->set_rules('discount', 'Discount', 'trim|numeric|required');
            }

            $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
            $this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|in_list[0,1]');
                       
            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $formData = array(
                    'code'              => $this->input->post('code',TRUE),
                    'discount_type'     => $this->input->post('discount_type', TRUE),
                    'discount'          => $this->input->post('discount',TRUE),
                    'start_date'        => date("Y-m-d", strtotime($this->input->post('start_date',TRUE))),
                    'end_date'          => date("Y-m-d", strtotime($this->input->post('end_date',TRUE))),
                    'status'            => $this->input->post('status',TRUE),
                    'date_updated'      => date("Y-m-d H:i:s")
                );

                if ($this->coupon_model->update($coupon_id, $formData)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_coupons_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => config_item('error_message')));
                }

                redirect('admin/coupons');
                exit();
            }
        }

        $this->data['details'] = $result;
    
        $this->template->build('admin/coupons/edit', $this->data);

    }

   /**
    * Update the coupon status.
    * 
    * @return void
    */
    public function status_update() 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        $coupon_id = $this->input->post('id',TRUE);
        $status = $this->input->post('status',TRUE);
        if (empty($coupon_id) || empty($status)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->coupon_model->as_array()->get($coupon_id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->coupon_model->update($coupon_id, array('status' => $status))) {
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
    * Check discount limit.
    * 
    * @return boolean
    */
    public function valid_percentage() 
    {
        $discount = $this->input->post('discount',TRUE);

        if ($discount > 100) {
            $this->form_validation->set_message('valid_percentage', 'Discount should not be greater than 100%');
            return false;
        } else {
            return true;
        }
    }

   /**
    * Delete coupon.
    * 
    * @param integer $coupon_id.
    * @return void.
    */
    public function delete($coupon_id = NULL) 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($coupon_id) || !is_numeric($coupon_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->coupon_model->as_array()->get_by(array('id' => $coupon_id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->coupon_model->delete($coupon_id)) {
            set_ajax_flashdata('success', lang('success_coupons_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
}
