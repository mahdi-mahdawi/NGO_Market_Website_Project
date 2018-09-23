<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Category extends Admin_Controller
{

    function __construct() 
    {
        parent::__construct();
        $this->data['parent'] = 2;
        $this->data['child'] = 4;
        
        //Load model 
        $this->load->model('admin/product_category_model');

        $this->load->library('form_validation');
        $this->template->title('Product Category');
    }

    
    public function index() {

        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
        $this->data['list'] = $this->product_category_model->as_array()->get_all_category(array('deleted' => 0));
        $this->template->build('admin/category/index', $this->data);
    }

    public function add() {
        

        if ($this->input->post('submit') && $this->input->post('submit') == 'ADD') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[1000]');
            $this->form_validation->set_rules('file_id', 'Image', 'trim|max_length[100]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $timestamp = date('Y-m-d H:i:s');

                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'url_slug' => url_title($this->input->post('name')),
                    'status' => $this->input->post('status'),
                    'image' => $this->input->post('file_id'),
                    'date_created' => $timestamp,
                    'date_updated' => $timestamp
                );

                if ($this->product_category_model->insert($data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_category_saved')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/product_category');
                exit();
            }
        }

        // Image upload variables
        $this->data['upload_folder'] = 'category';
        $this->data['type'] = 'category';
        $this->data['thumb_image'] = ($this->input->post('file_id')) ? $this->input->post('file_id') : '';
        $this->data['thumb_image_url'] = ($this->input->post('file_id') && $this->input->post('file_id')) ? base_url('uploads/category/' . $this->input->post('file_id')) : base_url('assets/admin/images/thumbnail-default.jpg');
        
        $this->template->load_asset(array('jquery_upload', 'select2', 'dialog'));
        
        $this->template->build('admin/category/add', $this->data);
    }

    public function edit($category_id = NULL) 
    {
       
        if (is_null($category_id) || !is_numeric($category_id)) {
            show_404();
        }

        $result = $this->product_category_model->as_array()->get_by(array('product_category_id' => $category_id));
        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[1000]');
            $this->form_validation->set_rules('file_id', 'Image', 'trim|max_length[100]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'url_slug' => url_title($this->input->post('name')),
                    'status' => $this->input->post('status'),
                    'image' => $this->input->post('file_id'),
                    'date_updated' => date('Y-m-d H:i:s')
                );

                if ($this->product_category_model->update($category_id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_category_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/product_category');
                exit();
            }
        }

        // Image upload variables
        $this->data['upload_folder'] = 'category';
        $this->data['type'] = 'category';
        $file_id = ($this->input->post('file_id')) ? $this->input->post('file_id') : $result['image'];
        $this->data['thumb_image'] = ($this->input->post('file_id')) ? $this->input->post('file_id') : $result['image'];
        $this->data['thumb_image_url'] = ($file_id) ? base_url('uploads/category/thumbs/' . $file_id) : base_url('assets/admin/images/thumbnail-default.jpg');

        $this->data['category'] = $result;

        $this->template->load_asset(array('jquery_upload','select2','dialog'));
        $this->template->build('admin/category/edit', $this->data);
    }

    public function status_update() {
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

        $result = $this->product_category_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->product_category_model->update($id, array('status' => $status))) {
            if ($status) {
                set_ajax_flashdata('success', lang('status_enabled'));
            } else {
                set_ajax_flashdata('success', lang('status_disabled'));
            }
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

    public function delete($category_id = NULL) 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($category_id) || !is_numeric($category_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->product_category_model->as_array()->get_by(array('product_category_id' => $category_id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->product_category_model->delete($category_id)) {
            set_ajax_flashdata('success', lang('success_category_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

}
