<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_Sizes extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load library
        $this->load->library('form_validation');
        $this->load->library('product_size');

        // Load model
        $this->load->model('admin/product_model');
        $this->load->model('admin/size_model');
        $this->load->model('admin/product_sizes_model');
    }

    /**
     * Get all the sizes for a product.
     *
     * @param  [type] $productId [description]
     * @return [type]         [description]
     */
    public function index($productId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        $sizes = $this->product_size->getAllSizes($productId);
        
        if (empty($product)) {
            show_404();
        }

        $response = [
            'sizes' => $sizes,
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
        $data['product_sizes'] = $this->size_model->as_array()->get_all();

        if (empty($product) || empty($data['product_sizes'])) {
            show_404();
        }

        $data['productId'] = $productId;
        
        $this->load->view('admin/product_sizes/create', $data);
    }

    /**
     * Create new product size.
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

        if ($this->product_size->addDifferentSizes($productId, $post)) {
            set_ajax_flashdata();
        }
    }

    /**
     * Edit the product sizes.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $productSizeId [description]
     * @return [type]             [description]
     */
    public function edit($productId, $productSizeId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        $product_sizes = $this->size_model->as_array()->get_all();
        $menu_sizes = $this->product_sizes_model->as_array()->get_by(array('id'=>$productSizeId, 'product_id' => $productId));

        if (empty($product) || empty($menu_sizes)) {
            show_404();
        }

        $data = [
            'productId' => $productId,
            'product_sizes' => $product_sizes,
            'menu_sizes' => $menu_sizes
        ];

        $this->load->view('admin/product_sizes/edit', $data);
    }

    /**
     * Update product sizes.
     *
     * @param  [type] $productId [description]
     * @param  [type] $productSizeId [description]
     * @return [type]         [description]
     */
    public function update($productId, $productSizeId)
    {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_404();
        }

        $post = $this->input->post(null, true);

        $data = [
                'product_id' => $productId,
                'size_id' => $post['size'],
                'price' => $post['size_price']
            ];
        
        if ($this->product_size->updateSizes($productId, $productSizeId, $data)) {
            set_ajax_flashdata();
        }
    }

    /**
     * Delete the product sizes.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $productSizeId [description]
     * @return [type]             [description]
     */
    public function delete($productId,  $productSizeId)
    {
        $product = $this->product_model->get_by(['product_id' => $productId]);
        if (empty($product)) {
            show_404();
        }

        $sizes = $this->product_sizes_model->as_array()->get_by(array('id'=>$productSizeId, 'product_id' => $productId));
        if (empty($sizes)) {
            show_404();
        }
        if ($this->product_size->deleteProductSize($productId, $productSizeId)) {
            set_ajax_flashdata('success', lang('size_deleted_successfully'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

    
}
