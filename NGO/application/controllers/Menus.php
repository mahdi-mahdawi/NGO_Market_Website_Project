<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menus extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->cms->get_page('menus');

        // Load model
        $this->load->model('public/product_model');
        $this->load->model('public/product_category_model');

        $this->template->set_partial('modal_wrapper', 'public/components/modal_body');

        // Load library
        $this->load->library('store');
    }

    /**
     * Show all the productes.
     *
     * @return void
     */
    public function index($category_slug = null)
    {
        $conditions = [];
        
        if (!is_null($category_slug)) {
            $category_slug = urldecode($category_slug);

            $category = $this->product_category_model->get_by(['url_slug' => $category_slug, 'status' => 1]);

            if (empty($category)) {
                show_404();
            }

            $conditions['product_category.url_slug'] = $category_slug;
        }

        $this->data['productes'] = transformMenuItems($this->product_model->get_all_product($conditions));
        $this->data['categories'] = $this->product_model->get_all_product_category();
        $this->data['category_slug'] = ($category_slug) ?: 'all';
        
        $this->template->build('public/menus/' . $this->store->getMenuLayout(), $this->data);
    }

    /**
     * Show the product details.
     *
     * @param  integer $product_id
     * @param  string $product_slug
     * @return void
     */
    public function view($product_id = null, $product_slug = null)
    {
        if (is_null($product_slug) || is_null($product_id)) {
            show_404();
        }

        $product_slug = urldecode($product_slug);

        $this->data['product'] = transformMenuProduct($this->product_model->get_product(['product.url_slug' => $product_slug, 'product.product_id' => $product_id]));
                
        if (empty($this->data['product'])) {
            show_404();
        }

        // Get related productes
        $this->data['related_productes'] = $this->product_model->get_related_productes($this->data['product']['product_category_id'], $product_id);

        $this->template->build('public/menus/view', $this->data);
    }
}
