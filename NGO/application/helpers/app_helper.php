<?php

function dd($value) {
    echo "<pre>";
    print_r($value);
    echo "<pre>";
    die();
}

// Output JSON
function response_json($data = [], $status_code = 200) {
	$CI = & get_instance();
	$CI->output->set_content_type('application/json');
	$CI->output->set_status_header($status_code);

	die(json_encode($data));
}

/**
 * Format the currency value.
 *
 * @param float $value
 * @return string
 */
function format_currency($value, $with_currency = true) {
    $keys = ['currency_symbol', 'currency_code_position', 'decimal_places', 'use_thousand_seperators', 'thousand_seperators', 'decimal_separators'];

    $configs = Settings::get($keys);

    extract($configs);

    $decimal_separators = ($decimal_separators == 'Comma') ? ',' : '.';
    $thousand_seperators = ($thousand_seperators == 'Comma') ? ',' : '.';

    $value = number_format($value, $decimal_places, $decimal_separators, $thousand_seperators);

    if(!$with_currency) {
        return $value;
    }

    return ($currency_code_position == 'left') ? $currency_symbol . ' ' . $value  : $value . ' ' . $currency_symbol;
}

/**
 * Get the uploaded image URL.
 * 
 * @param  string $image
 * @param  string $type
 * @return string
 */
function get_image_path($image, $type) {

    if(!$image) {
        return base_url('assets/public/images/default.png');
    }

    switch ($type) {
        case 'product':
            $path = 'uploads/product/';
            break;

        case 'category':
            $path = 'uploads/category/';
            break;
    }

    return base_url($path . $image);
}

/**
 * Get the checkout type text.
 *
 * @param integer $value
 * @return string
 */
function get_checkout_type_text($value) {
    $types = [
        1   => lang('label.delivery'),
        2   => lang('label.carry_out'),
        3   => lang('label.dine_in'),
    ];

    return $types[$value];
}

/**
 * Create one time paymen token.
 * 
 * @return string
 */
function create_payment_token() {
    return random_string('unique');
}

/**
 * Get the complete URL.
 * 
 * @return string
 */
function current_url_full() {
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

/**
 * Get the order status text.
 * 
 * @param  integer $order_status
 * @return string
 */
function get_order_status($order_status) {
    $status = [
        0   => '<span class="label label-default">' . lang('label.incompleted') . '</span>', 
        1   => '<span class="label label-warning">' . lang('label.pending') . '</span>', 
        2   => '<span class="label label-primary">' . lang('label.confirmed') . '</span>', 
        3   => '<span class="label label-danger">' . lang('label.cancelled') . '</span>', 
        4   => '<span class="label label-success">' . lang('label.delivered') . '</span>'
    ];

    return $status[$order_status];
}

/**
 * Get the part size.
 *
 * @param  integer $value
 * @return string
 */
function get_party_size($value) {
    $party_size = [
        1   => '1 - 5',
        2   => '6 - 10',
        3   => '11 - 15',
        4   => '16 - 20',
        5   => 'Above 20'
    ];

    return $party_size[$value];
}

/**
 * Encode order reference.
 * 
 * @param  string $order_reference
 * @return string
 */
function encode_order_reference($order_reference) {
   return base64_encode($order_reference);
}

/**
 * Decode the order reference string.
 * 
 * @param  string $order_reference_encoded
 * @return string
 */
function decode_order_reference($order_reference_encoded) {
   return base64_decode($order_reference_encoded);   
}

/**
 * Format the order.
 * 
 * @param  array $order
 * @return array
 */
function format_order($order) {
    $order['checkout_type']     = get_checkout_type_text($order['checkout_type']);
    $order['is_preorder']       = ($order['is_preorder']) ? 'Yes' : 'No';

    return $order;
}

/**
 * Get the current language key.
 * 
 * @return string
 */
function get_active_language() {
    $CI =& get_instance();

    $language = $CI->session->userdata('language');
    return ($language) ? $language : config_item('language');
}

/**
 * Transform menu items.
 * 
 * @param  array $products
 * @return array
 */
function transformMenuItems($products = []) 
{
        if(empty($products)) {
            return FALSE;
        }

        $orderProductId = null;

        foreach($products as $row) 
        {
            if($orderProductId != $row['product_id'])
            {
                $orderProductId = $row['product_id'];

                $result[$orderProductId] = [
                    'product_id' => $row['product_id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'url_slug' => $row['url_slug'],
                    'description' =>$row['description'],
                    'image' =>$row['image'],
                    'category_name' => $row['category_name'],
                    'product_category_id' => $row['product_category_id'],
                    'product_type_id' => $row['product_type_id'],
                    'product_category_url_slug' => $row['product_category_url_slug']
                ];
            }

            if(isset($row['size_id'])) {
                $result[$orderProductId]['options'][$row['size_id']] = [
                    'size_id' => $row['size_id'],
                    'size' => $row['size'],
                    'menu_price' => $row['menu_price']
                 
                ];
            }
        }

        return $result;
}

/**
 * Transform individual product.
 * 
 * @param  array $products
 * @return array
 */
function transformMenuProduct($products = []) 
{
        if(empty($products)) {
            return FALSE;
        }

        $orderProductId = null;

        foreach($products as $row) 
        {
            if($orderProductId != $row['product_id'])
            {
                $orderProductId = $row['product_id'];

                $result = [
                    'product_id' => $row['product_id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'url_slug' => $row['url_slug'],
                    'description' =>$row['description'],
                    'image' =>$row['image'],
                    'category_name' => $row['category_name'],
                    'product_category_id' => $row['product_category_id'],
                    'product_type_id' => $row['product_type_id'],
                    'product_category_url_slug' => $row['product_category_url_slug']
                ];
            }

            if(isset($row['size_id'])) {
                $result['options'][$row['size_id']] = [
                    'size_id' => $row['size_id'],
                    'size' => $row['size'],
                    'menu_price' => $row['menu_price']
                 
                ];
            }
        }

        return $result;
}

/**
 * Transform individual orders.
 * 
 * @param  array $products
 * @return array
 */
function transformIndividualOrder($products = []) 
{
        if(empty($products)) {
            return FALSE;
        }

        $result['first_name'] = $products['first_name'];
        $result['email'] = $products['email'];
        $result['city'] = $products['city'];
        $result['last_name'] = $products['last_name'];
        $result['phone'] = $products['phone'];
        $result['order_id'] = $products['order_id'];
        $result['order_reference'] = $products['order_reference'];
        $result['tax'] = $products['tax'];
        $result['tax_amount'] = $products['tax_amount'];
        $result['delivery_charge'] = $products['delivery_charge'];
        $result['subtotal'] = $products['subtotal'];
        $result['payed_amount']= $products['payed_amount'];
        $result['payment_status'] = $products['payment_status'];
        $result['payment_mode'] = $products['payment_mode'];
        $result['checkout_type'] = $products['checkout_type'];
        $result['is_preorder'] = $products['is_preorder'];
        $result['preorder_date'] = $products['preorder_date'];
        $result['preorder_time'] = $products['preorder_time'];
        $result['coupon_id'] = $products['coupon_id'];
        $result['coupon_discount'] = $products['coupon_discount'];
        $result['order_date'] = $products['order_date'];
        $result['order_status'] = $products['order_status'];
        $result['zipcode'] = $products['zipcode'];
        $result['address_line_1'] = $products['address_line_1'];
        $result['address_line_2'] = $products['address_line_2'];

        $orderProductId = null;

        foreach($products['items'] as $row) 
        {
            if($orderProductId != $row['order_item_id'])
            {
                $orderProductId = $row['order_item_id'];

                $result['items'][$orderProductId] = [
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                    'subtotal' =>$row['subtotal'],
                    'instruction' => $row['instruction'],
                    'sizes' => $row['sizes'],
                    'size_id' => $row['size_id'],
                    'menu_price' => $row['menu_price'],
                    'order_item_id' => $row['order_item_id']
                ];
            }

            if(isset($row['modifier_item_id'])) {
                $result['items'][$orderProductId]['options'][] = [
                    'modifier_name' => $row['modifier_name'],
                    'modifier_item_id' => $row['modifier_item_id'],
                    'modifier_item_name' => $row['modifier_item_name'],
                    'modifier_item_price' => $row['modifier_item_price'],
                    'modifier_id' => $row['modifier_id']
                ];
            } 
        }

        return $result;
    }

/**
 * Transform Mail.
 * 
 * @param  array $products
 * @return array
 */
function transformMail($products = []) 
{
    if(empty($products)) {
        return FALSE;
    }
    
    $tabledata['options']=array();
    
    foreach($products['items'] as $row) 
    { 
        $tabledata['options']='<tr>';
        $tabledata['options']=$tabledata['options'].'<td width="50%">'.$row["name"].'('. $row["sizes"].')<br>';
        if(isset($row['options'])){
            foreach($row['options'] as $options) {
                $tabledata['options']=$tabledata['options'].''.$options["modifier_item_name"].'('.$options["modifier_item_price"].')<br>' ;
            }
        } 
        $tabledata['options']=$tabledata['options'].'</td>
            <td width="15%">'.$row["price"].'</td>
            <td width="15%">'.$row["quantity"].'</td>
            <td width="20%">'.$row["subtotal"].'</td>
            </tr>';
        $result[]=$tabledata;
    }
    return $result;
}
