<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['parent'] = 2;
        $this->data['child'] = 5;
        
        $this->template->title('Product Items');

        // Load model.
        $this->load->model('admin/product_model');
        $this->load->model('admin/product_category_model');
        $this->load->model('admin/product_type_model');
        $this->load->model('admin/size_model');
        $this->load->model('admin/product_sizes_model');

        // Load library.
        $this->load->library('form_validation');
    }

    /**
     * Get product items.
     *
     * @return void
     */
    public function index()
    {
        $this->data['list'] = $this->product_model->get_all_product();

        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
        
        $this->template->build('admin/product/index', $this->data);
    }

    /**
     * Add new product item.
     *
     * @return void
     */
    public function add()
    {
        if ($this->input->post('submit') && $this->input->post('submit') == 'ADD') {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('is_featured', 'Featured', 'trim|required|in_list[0,1]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[1000]');
            $this->form_validation->set_rules('file_id', 'Image', 'trim|max_length[100]');
            $this->form_validation->set_rules('product_type', 'Product type', 'trim|required');
            $this->form_validation->set_rules('different_size', 'Different size', 'trim|required|in_list[0,1]');
            if ($this->input->post('different_size') == '0') {
                $this->form_validation->set_rules('item_price', 'Item Price', 'trim|required|numeric');
            }
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
            
            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run() == true) {
                $timestamp = date('Y-m-d H:i:s');

                $data = array(
                    'name'              => $this->input->post('name', true),
                    'description'       => $this->input->post('description', true),
                    'product_category_id'  => $this->input->post('category', true),
                    'is_featured'       => $this->input->post('is_featured', true),
                    'url_slug'          => url_title($this->input->post('name', true), '-', true),
                    'status'            => $this->input->post('status', true),
                    'image'             => $this->input->post('file_id'),
                    'price'             => $this->input->post('item_price', true),
                    'product_type_id'      => $this->input->post('product_type', true),
                    'has_different_size' => $this->input->post('different_size', true),
                    'date_created'      => $timestamp,
                    'date_updated'      => $timestamp
                );
                if ($this->input->post('different_size') == '0') {
                    $data['price'] = $this->input->post('item_price', true);
                    $result = $this->product_model->insert($data);
                } else {
                    $result = $this->product_model->insert($data);
                }

                if ($result) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_items_saved')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/product/edit/'.$result);
                exit();
            }
        }

        // Image upload variables.
        $this->data['upload_folder'] = 'product';
        $this->data['type'] = 'product';
        $this->data['thumb_image'] = ($this->input->post('file_id')) ? $this->input->post('file_id') : '';
        $this->data['thumb_image_url'] = ($this->input->post('file_id') && $this->input->post('file_id')) ? base_url('uploads/product/' . $this->input->post('file_id')) : base_url('assets/admin/images/thumbnail-default.jpg');

        $this->data['category'] = $this->product_category_model->as_array()->get_all();
        $this->data['product_type'] = $this->product_type_model->as_array()->get_all();
        $this->data['product_sizes'] = $this->size_model->as_array()->get_all();

        $this->template->load_asset(array('jquery_upload', 'select2', 'dialog'));

        $this->template->build('admin/product/add', $this->data);
    }

    /**
     * Update the product item.
     *
     * @param  integer $product_id
     * @return void
     */
    public function edit($product_id = null)
    {
        if (is_null($product_id) || !is_numeric($product_id)) {
            show_404();
        }

        $result = $this->product_model->get_by(array('product_id' => $product_id));
        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('is_featured', 'Featured', 'trim|required|in_list[0,1]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[1000]');
            $this->form_validation->set_rules('file_id', 'Image', 'trim|max_length[100]');
            $this->form_validation->set_rules('product_type[]', 'Product type', 'trim|required');
            $this->form_validation->set_rules('different_size', 'Different size', 'trim|required|in_list[0,1]');
            if ($this->input->post('different_size') == '0') {
                $this->form_validation->set_rules('item_price', 'Item Price', 'trim|required|numeric');
            } 
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run() == true) {
                $product_type = array();

                $data = array(
                    'name'              => $this->input->post('name', true),
                    'description'       => $this->input->post('description', true),
                    'product_category_id'  => $this->input->post('category', true),
                    'is_featured'       => $this->input->post('is_featured', true),
                    'url_slug'          => url_title($this->input->post('name', true), '-', true),
                    'status'            => $this->input->post('status', true),
                    'product_type_id'      => $this->input->post('product_type', true),
                    'image'             => $this->input->post('file_id'),
                    'has_different_size' => $this->input->post('different_size', true),
                    'date_updated'      => date('Y-m-d H:i:s')
                );

                $menu_sizes = $this->product_sizes_model->as_array()->get_many_by(array('product_id' => $product_id));
                
                if ($this->input->post('different_size') == '0') {
                    $data['price'] = $this->input->post('item_price', true);

                    $result = $this->product_model->update($product_id, $data);
                    $this->product_sizes_model->delete_by(array('product_id' => $product_id));
                } else {
                    $post = $this->input->post(null, true);
                    $data['price'] = 0;
                                       
                    $result = $this->product_model->update($product_id, $data);
                }
                if ($result) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_items_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/product');
                exit();
            }
        }

        // Image upload variables.
        $this->data['upload_folder'] = 'product';
        $this->data['type'] = 'product';
        $file_id = ($this->input->post('file_id')) ? $this->input->post('file_id') : $result['image'];
        $this->data['thumb_image'] = ($this->input->post('file_id')) ? $this->input->post('file_id') : $result['image'];
        $this->data['thumb_image_url'] = ($file_id) ? base_url('uploads/product/thumbs/' . $file_id) : base_url('assets/admin/images/thumbnail-default.jpg');

        $this->data['category'] = $this->product_category_model->as_array()->get_all();
        $this->data['product'] = $this->product_model->as_array()->get_by(array('product.product_id' => $product_id));
        $this->data['product_type'] = $this->product_type_model->as_array()->get_all();
        $this->data['product_sizes'] = $this->size_model->as_array()->get_all();
        $this->data['menu_sizes'] = $this->product_sizes_model->as_array()->get_many_by(array('product_id' => $product_id));

        $this->template->load_asset(array('jquery_upload', 'select2', 'dialog', 'editor'));

        $this->template->build('admin/product/edit', $this->data);
    }
   
    /**
    * Update the product status.
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

        $result = $this->product_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->product_model->update($id, array('status' => $status))) {
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
     * Delete the product item.
     *
     * @param  integer $product_id
     * @return JSON
     */
    public function delete($product_id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($product_id) || !is_numeric($product_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->product_model->as_array()->get_by(array('product_id' => $product_id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->product_model->delete($product_id)) {
            set_ajax_flashdata('success', lang('success_items_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
}
