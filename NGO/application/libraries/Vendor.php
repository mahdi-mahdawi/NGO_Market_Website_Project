<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendor
{
    public function __construct()
    {
        // Load model
       
        $this->load->model('public/product_model');
      
        // Load helper
        $this->load->helper('string');
        $this->load->helper('date');

        $this->load->library('product_modifiers');
      
    }

    /**
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @return string.
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
     * Get the product.
     * 
     * @param [type] $restaurantCode [description]
     * @param [type] $productId      [description]
     *
     * @return [type] [description]
     */
    public function getProduct($productId)
    {
        return $this->product_model->get_product($productId);
    }

    /**
     * Get the product modifier.
     * 
     * @param [type] $productId      [description]
     *
     * @return [type] [description]
     */
    public function getProductModifiers($productId)
    {
        return $this->product_modifiers->getAllModifiers($productId);
    }
}
