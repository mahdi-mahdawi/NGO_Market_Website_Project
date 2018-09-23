<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_Modifier extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load library
        $this->load->library('form_validation');
        $this->load->library('product_modifiers');

        // Load model
        $this->load->model('admin/product_model');
    }

    /**
     * Get all the modifier for a product.
     *
     * @param  [type] $productId [description]
     * @return [type]         [description]
     */
    public function index($productId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        if (empty($product)) {
            show_404();
        }

        $response = [
            'modifiers' => $this->product_modifiers->getAllModifiers($productId),
            'currency_symbol' => Settings::get('currency_symbol'),
            'product_id' => $productId
        ];

        response_json($response, 200);
    }

    /**
     * Show the create modal.
     *
     * @param  [type] $productId [description]
     * @return [type]         [description]
     */
    public function show($productId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        if (empty($product)) {
            show_404();
        }

        $data['productId'] = $productId;
        
        $this->load->view('admin/product_modifier/create', $data);
    }

    /**
     * Create new modifier.
     *
     * @param  [type] $productId [description]
     * @return [type]         [description]
     */
    public function create($productId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        if (empty($product)) {
            show_404();
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_404();
        }

        $post = $this->input->post(null, true);

        if ($this->product_modifiers->addModifier($productId, $post)) {
            set_ajax_flashdata();
        }
    }

    /**
     * Edit the product modifier.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $modifierId [description]
     * @return [type]             [description]
     */
    public function edit($productId, $modifierId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        if (empty($product)) {
            show_404();
        }

        $modifier = $this->product_modifiers->getModifier($productId, $modifierId);
        if (empty($modifier)) {
            show_404();
        }

        $data = [
            'productId' => $productId,
            'modifier' => $modifier
        ];

        $this->load->view('admin/product_modifier/edit', $data);
    }


    /**
     * Update modifier.
     *
     * @param  [type] $productId [description]
     * @param  $modifierId [description]
     * @return [type]         [description]
     */
    public function update($productId, $modifierId)
    {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_404();
        }

        $post = $this->input->post(null, true);

        if ($this->product_modifiers->updateModifier($productId, $modifierId, $post)) {
            set_ajax_flashdata();
        }
    }

    /**
     * Delete the product modifier.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $modifierId [description]
     * @return [type]             [description]
     */
    public function delete($productId, $modifierId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        if (empty($product)) {
            show_404();
        }

        $modifier = $this->product_modifiers->getModifier($productId, $modifierId);
        if (empty($modifier)) {
            show_404();
        }
        if ($this->product_modifiers->deleteModifier($productId, $modifierId)) {
            set_ajax_flashdata('success', lang('modifier_deleted_successfully'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }
}
