<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Cart extends CI_Cart
{
    public function __construct()
    {
        parent::__construct();

        $this->product_name_rules = '\d\D';

        // Load library
        $this->load->library('form_validation');
        $this->load->library('coupons');
    }

    /**
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param string $var
     * @return Instance of CI
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
     * Check the product already exist in cart.
     *
     * @param  integer $product_id
     * @return boolean
     */
    public function in_cart($product_id)
    {
        $contents = $this->contents();

        if (empty($contents)) {
            return false;
        }

        foreach ($contents as $row) {
            if ($row['id'] == $product_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Apply coupon to the cart.
     *
     * @param  array $coupon
     * @return boolean
     */
    public function apply_coupon($coupon)
    {
        if ($this->total_items() == 0) {
            return false;
        }

        // If coupon already applied ?
        if ($this->coupon_applied()) {
            return false;
        }

        // Fixed amount
        if ($coupon['discount_type'] == 'fixed_amount') {
            $coupon_discount = $coupon['discount'];
        }

        // Percentage
        else {
            $coupon_discount = ($this->_cart_contents['cart_total']) * ($coupon['discount'] / 100);
        }

        $this->_cart_contents['coupon_applied'] = $coupon['code'];
        $this->_cart_contents['coupon_discount'] = $coupon_discount;
        $this->_cart_contents['coupon_id'] = $coupon['id'];

        $this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));

        return true;
    }

    /**
     * Remove the coupon.
     *
     * @return boolean
     */
    public function remove_coupon()
    {
        unset($this->_cart_contents['coupon_applied']);
        unset($this->_cart_contents['coupon_discount']);
        unset($this->_cart_contents['coupon_id']);

        $this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));
    }

    /**
     * Get the applied coupon code.
     *
     * @return string
     */
    public function coupon_applied()
    {
        return isset($this->_cart_contents['coupon_applied']) ? $this->_cart_contents['coupon_applied'] : null;
    }

    /**
     * Get the coupon discount applied.
     *
     * @return string
     */
    public function coupon_discount()
    {
        return isset($this->_cart_contents['coupon_discount']) ? $this->_cart_contents['coupon_discount'] : null;
    }

    /**
     * Get the coupon ID of applied coupon.
     *
     * @return int
     */
    public function coupon_id()
    {
        return isset($this->_cart_contents['coupon_id']) ? $this->_cart_contents['coupon_id'] : null;
    }


    /*
    * This functions overrides the core cart _insert function.
    * We need it to implement the product attributes / options
    */
    protected function _insert($items = array())
    {
        if (! is_array($items) or count($items) === 0) {
            return false;
        }

        if (! isset($items['id'], $items['qty'], $items['price'], $items['name'])) {
            return false;
        }

        $items['qty'] = (float) $items['qty'];

        if ($items['qty'] == 0) {
            return false;
        }

        // Validate the product ID. It can only be alpha-numeric, dashes, underscores or periods
        // Not totally sure we should impose this rule, but it seems prudent to standardize IDs.
        // Note: These can be user-specified by setting the $this->product_id_rules variable.
        if (! preg_match('/^['.$this->product_id_rules.']+$/i', $items['id'])) {
            return false;
        }

        // Validate the product name. It can only be alpha-numeric, dashes, underscores, colons or periods.
        // Note: These can be user-specified by setting the $this->product_name_rules variable.
        if ($this->product_name_safe && ! preg_match('/^['.$this->product_name_rules.']+$/i'.(UTF8_ENABLED ? 'u' : ''), $items['name'])) {
            return false;
        }

        // Prep the price. Remove leading zeros and anything that isn't a number or decimal point.
        $items['price'] = (float) $items['price'];

        if (isset($items['size']) && count($items['size']) > 0) {
            if (isset($items['options']) && count($items['options']) > 0) {
                $rowid = md5($items['id'].serialize($items['size']).serialize($items['options']));
            } else {
                // No options were submitted so we simply MD5 the product ID.
                // Technically, we don't need to MD5 the ID in this case, but it makes
                // sense to standardize the format of array indexes for both conditions
                $rowid = md5($items['id'].serialize($items['size']));
            }
        }
        else{

            if (isset($items['options']) && count($items['options']) > 0) {
                $rowid = md5($items['id'].serialize($items['options']));
            } else {
                // No size and options were submitted so we simply MD5 the product ID.
                // Technically, we don't need to MD5 the ID in this case, but it makes
                // sense to standardize the format of array indexes for both conditions
                $rowid = md5($items['id']);
            }
        }

        // Now that we have our unique "row ID", we'll add our cart items to the master array
        // grab quantity if it's already there and add it on
        $old_quantity = isset($this->_cart_contents[$rowid]['qty']) ? (int) $this->_cart_contents[$rowid]['qty'] : 0;

        // Re-create the entry, just to make sure our index contains only the data from this submission
        $items['rowid'] = $rowid;
        $items['qty'] += $old_quantity;
        $this->_cart_contents[$rowid] = $items;

        return $rowid;
    }

    /**
     * Add the options price to product subtotal.
     *
     * @return [type] [description]
     */
    protected function _update_options()
    {
        $this->_cart_contents['cart_total'] = 0;

        foreach ($this->_cart_contents as $key => $val) {
            if (!is_array($val)) {
                continue;
            }

            $subtotal = $this->_cart_contents[$key]['price'];

            if (!empty($this->_cart_contents[$key]['options'])) {
                foreach ($this->_cart_contents[$key]['options'] as $option) {
                    $subtotal += $option['price'];
                }
            }

            $subtotal *= $this->_cart_contents[$key]['qty'];

            $this->_cart_contents['cart_total'] += $subtotal;
            $this->_cart_contents[$key]['subtotal'] = $subtotal;
        }

        $this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));
    }

    /**
     * Add product to cart.
     *
     * @param [type] $product        [description]
     * @param [type] $post           [description]
     */
    public function addToCart($product, $post)
    {
        $options = [];

        if (isset($post['product']['choices'])) {
            $selectedChoices = $post['product']['choices'];
            $modifiers = $this->vendor->getProductModifiers($product['product_id']);

            foreach ($selectedChoices as $modifierId => $selectedChoice) {
                foreach ($selectedChoice as $selectedItem) {
                    $choice = $modifiers[$modifierId]['items'][$selectedItem];
                    $choice['modifier'] = [
                        'id' => $modifiers[$modifierId]['id'],
                        'name' => $modifiers[$modifierId]['name']
                    ];

                    $options[] = $choice;
                }
            }
        }

        $data = [
            'id' => $product['product_id'],
            'qty' => $post['quantity'],
            'size_id' => (isset($post['size_id'])) ? $post['size_id'] : '',
            'size' => (isset($post['size_id'])) ? $product['options'][$post['size_id']]['size'] : '',
            'price' => (isset($post['size_id'])) ? $product['options'][$post['size_id']]['menu_price'] : $product['price'],
            'name' => $product['name'],
            'options' => $options,
            'note' => isset($post['note']) ? $post['note'] : ''
        ];

        return $this->insert($data);
    }

    /**
     * Validate the product modifiers.
     *
     * @param  [type] $modifiers [description]
     * @param  [type] $post      [description]
     * @return [type]            [description]
     */
    public function validation($modifiers, $post)
    {
        $errors = [];
        $choices = [];

        if (isset($post['product']['choices'])) {
            $choices = $post['product']['choices'];
        }

        if (empty($modifiers) && !empty($choices)) {
            response(['status' => 0], 422);
        }

        foreach ($modifiers as $modifier) {
            $modifierId = $modifier['id'];
            $chosenCount =  isset($post['product']['choices'][$modifierId]) ? count($post['product']['choices'][$modifierId]) : 0;

            if ($chosenCount < $modifier['minimum']) {
                $errors[$modifierId] = lang('text.select_least') . $modifier['minimum'] . lang('text.cart_choice');
            }

            if ($chosenCount > $modifier['maximum']) {
                $errors[$modifierId] = lang('text.select_most') . $modifier['maximum'] . lang('text.cart_choice');
            }
        }

        return $errors;
    }
}
