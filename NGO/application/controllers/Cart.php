<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cart extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load library
        $this->load->library('store');
        $this->load->library('coupons');
        $this->load->library('vendor');

        // Load model
        $this->load->model('public/product_model');
    }

    /**
     * Update the cart content.
     *
     * @return JSON
     */
    public function add($product_id)
    {
        $row_id = null;

        if (is_null($product_id) || !is_numeric($product_id)) {
            response_json(['status' => 0], 404);
        }

        $product = transformMenuProduct($this->product_model->get_product(['product.product_id' => $product_id]));
        
        if (empty($product)) {
            response_json(['status' => 0], 404);
        }

        $modifiers = $this->vendor->getProductModifiers($product_id);

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->input->post(null, true);
            // Form validation
            $errors = $this->cart->validation($modifiers, $post);

            if (empty($errors)) {
                if ($this->cart->addToCart($product, $post)) {
                    response_json(['status' => 1, 'cart' => $this->cart->contents(), 'count' => $this->cart->total_items()], 200);
                }
            }
        }

        $data = [
            'product' => $product,
            'modifiers' => $modifiers,
            'errors' => $errors
        ];
                        
        $response = [
            'status' => 0,
            'html' => $this->load->view('public/menus/modal_product_customization', $data, true)
        ];

        response_json($response, 200);
    }

    /**
     * Get the cart contents.
     *
     * @return JSON
     */
    public function all()
    {
        response_json(['status' => 1, 'contents' => $this->cart->contents(), 'count' => $this->cart->total_items()]);
    }

    /**
     * Get the cart table view.
     *
     * @return html
     */
    public function table()
    {
        if ($this->store->getSubTotal() == 0) {
            response_json(['status' => 1]);
        }

        $this->data['contents']           = $this->cart->contents();
        $this->data['tax_text']           = Settings::get('tax');
        $this->data['tax']                = $this->store->getTax();
        $this->data['delivery_charge']    = $this->store->getDeliveryCharge();
        $this->data['sub_total']          = $this->store->getSubTotal();
        $this->data['grand_total']        = $this->store->getGrandTotal();
        $this->data['coupon_applied']     = $this->cart->coupon_applied();
        $this->data['coupon_discount']    = $this->cart->coupon_discount();

        $view = $this->load->view('public/checkout/cart', $this->data, true);

        response_json(['status' => 1, 'html' => $view]);
    }

    /**
     * Remove the item from the cart.
     *
     * @param  string $row_id
     * @return void
     */
    public function remove($row_id = null)
    {
        if (is_null($row_id)) {
            show_404();
        }

        if ($this->cart->remove($row_id)) {
            redirect('checkout');
            exit();
        }
    }

    /**
     * Apply the coupon code.
     *
     * @return JSON
     */
    public function apply_coupon()
    {
        if ($this->input->post('coupon_code')) {
            $this->form_validation->set_rules('coupon_code', 'lang:label.coupon', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            // Run the form validation
            if (!$this->form_validation->run()) {
                response_json(['status' => 0, 'error' => form_error('coupon_code')]);
            }

            if (!$this->store->hasMinimumOrderAmount()) {
                response_json(['status' => 0, 'error' => lang('text.coupon_not_applicable')]);
            }

            // Apply the coupon
            if (!$this->coupons->apply($this->input->post('coupon_code'))) {
                response_json(['status' => 0, 'error' => lang('text.coupon_invalid')]);
            }

            $this->table();
        }
    }

    /**
     * Remove the applied coupon.
     *
     * @return JSON
     */
    public function remove_coupon()
    {
        if ($this->input->post('operation')) {
            $this->coupons->remove();

            $this->table();
        }
    }
}
