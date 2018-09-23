<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order_Model extends MY_Model
{
    public $_table = 'order';
    protected $primary_key = 'order_id';
    protected $soft_delete = TRUE;
 
    public function __construct()
    {
        parent::__construct();

        // Load helper
        $this->load->helper('string');
    }

    public function createOrder($post, $items) {
        
        $address_id = $this->saveAddress($post);
        $order_reference = $this->generateOrderReference();

        $order = [
            'order_reference'       => $order_reference,
            'customer_id'           => $post['customer_id'],
            'address_id'            => $address_id,
            'guest_checkout'        => $post['guest_checkout'],
            'tax'                   => $post['tax'],
            'tax_amount'            => $post['tax_amount'],
            'delivery_charge'       => $post['delivery_charge'],
            'subtotal'              => $post['subtotal'],
            'payed_amount'          => $post['payed_amount'],
            'payment_mode'          => $post['payment_mode'],
            'order_status'          => $post['order_status'],
            'checkout_type'         => $post['checkout_type'],
            'order_date'            => date('Y-m-d H:i:s'),
            'is_preorder'           => isset($post['is_preorder']) ? $post['is_preorder'] : 0,
            'coupon_id'             => $post['coupon_id'],
            'coupon_discount'       => $post['coupon_discount']
        ];

        if($order['is_preorder']) {
            $order['preorder_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $post['preorder_date'])));
            $order['preorder_time'] = $post['preorder_time'];
        }

        if(isset($post['payment_status'])) {
            $order['payment_status'] = $post['payment_status'];
        }

        $order_id = $this->insert($order);

        $this->saveItems($items, $order_id);

        return $order_reference;
    }

    /**
     * Save the order address.
     * 
     * @param  array $address
     * @return integer
     */
    public function saveAddress($address) {
        $data = [
            'first_name'        => $address['first_name'],
            'last_name'         => $address['last_name'],
            'email'             => $address['email'],
            'phone'             => $address['mobile'],
            'city'              => $address['city'],
            'zipcode'           => $address['zipcode'],
            'address_line_1'    => $address['address_line_1'],
            'address_line_2'    => $address['address_line_2']
        ];

        $this->db->insert('order_address', $data);

        return $this->db->insert_id();
    }

    /**
     * Save the order items.
     * 
     * @param  array $items
     * @return boolean
     */
    public function saveItems($items, $order_id) {
        
        foreach($items as $item) {
            $data = [
                'order_id'      => $order_id,
                'item_id'       => $item['id'],
                'quantity'      => $item['qty'],
                'price'         => $item['price'],
                'subtotal'      => $item['subtotal'],
                'instruction'   => $item['note']
            ];

            $this->db->insert('order_items', $data);
            $orderProductId = $this->db->insert_id();

            if(!empty($item['size_id'])) {
                $this->_save_order_sizes($orderProductId, $item);
            }

            if(empty($item['options'])) {
                continue;
            }

            $this->_save_products_modifiers($orderProductId, $item['options']);
        }

    }

    /**
     * Save the items modifiers.
     * 
     * @param  array $options [description]
     * @param  integer $orderProductId [description]
     * @return [type]           [description]
     */
    private function _save_products_modifiers($orderProductId, $options) {
        foreach($options as $option) {
            $data = [
                'order_item_id' => $orderProductId,
                'modifier_id' => $option['modifier']['id'],
                'modifier_name' => $option['modifier']['name'],
                'item_id' => $option['id'],
                'item_name' => $option['name'],
                'item_price' => $option['price']
            ];

            $this->db->insert('orders_items_modifiers', $data);
        }

        return true;
    }

    /**
     * Save the different size items.
     * 
     * @param  array $options [description]
     * @param  integer $orderProductId [description]
     * @return [type]           [description]
     */
    private function _save_order_sizes($orderProductId, $items) {
        
        $data = [
            'order_item_id' => $orderProductId,
            'size_id' => $items['size_id'],
            'price' => $items['price']
        ];

        $this->db->insert('order_item_size', $data);
     
        return true;
    }

    public function generateOrderReference() {
        $order_reference = random_string('numeric', 5);
        $response = $this->order_model->isOrderReferenceExist($order_reference);

        if(!$response) {
            return $order_reference;
        }

        $this->generateOrderReference();
    }

    /**
     * Check the order_reference exist or not ?
     * 
     * @param  string  $order_reference
     * @return boolean
     */
    public function isOrderReferenceExist($order_reference) {
        $order = $this->get_by(['order_reference' => $order_reference]);

        return (empty($order)) ? false : true;
    }

    /**
     * Get the order with billing details.
     * Note the status is not considered here. Used in payment processing.
     * 
     * @param  string $order_reference
     * @return array
     */
    public function getOrderWithBillingAddress($order_reference) {
        $this->db->select(['order.*', 'order_address.*']);
        $this->db->from('order');
        $this->db->join('order_address', 'order_address.address_id = order.address_id');
        $this->db->where(['order.deleted' => 0, 'order_reference' => $order_reference]);

        return $this->db->get()->row_array();
    }

    /**
     * Get the order details.
     * 
     * @param  string $order_reference
     * @param  integer $customer_id
     * @return array
     */
    public function getOrder($order_reference, $customer_id = null) {
        $this->db->select(['order.*', 'order_address.*']);
        $this->db->from('order');
        $this->db->join('order_address', 'order_address.address_id = order.address_id');
        $this->db->where(['order_status !=' => 0, 'order.deleted' => 0, 'order_reference' => $order_reference]);

        if(!is_null($customer_id)) {
            $this->db->where(['customer_id' => $customer_id]);
        }

        $order = $this->db->get()->row_array();

        // Get the order items
        $this->db->select('order_items.*, product.name');
        $this->db->select(['order_items.order_item_id as order_item_id', 'OPM.modifier_id as modifier_id', 'OPM.modifier_name as modifier_name', 'OPM.item_id as modifier_item_id', 'OPM.item_name modifier_item_name', 'OPM.item_price as modifier_item_price','ODS.size_id as size_id','ODS.price as menu_price','sizes.sizes']);
        $this->db->from('order_items');
        $this->db->join('product', 'product.product_id = order_items.item_id');
        $this->db->join('orders_items_modifiers OPM', 'OPM.order_item_id = order_items.order_item_id', 'left');
        $this->db->join('order_item_size ODS', 'ODS.order_item_id = order_items.order_item_id','left');
        $this->db->join('sizes', 'sizes.id = ODS.size_id','left');
        $this->db->where(['order_id' => $order['order_id']]);

        $order['items'] = $this->db->get()->result_array();

        return $order;
    }

    /**
     * Get all orders of a customer.
     * 
     * @param  integer $customer_id
     * @return array
     */
    public function getAllOrders($customer_id = null) {
        $this->db->select(['order.*', 'order_address.first_name', 'order_address.last_name', 'order_address.phone']);
        $this->db->from('order');
        $this->db->join('order_address', 'order_address.address_id = order.address_id');
        $this->db->where(['order_status !=' => 0, 'order.deleted' => 0, 'payment_status !=' => 0]);

        if(!is_null($customer_id)) {
            $this->db->where(['customer_id' => $customer_id]);
        }

        $this->db->order_by('order_id', 'desc');

        return $this->db->get()->result_array();
    }

    /**
     * Get the orders count.
     * 
     * @param  string $date
     * @return integer
     */
    public function getOrdersCount($date = null) {
        $this->db->select(['order.order_reference']);
        $this->db->from('order');
        $this->db->where(['order_status !=' => 0, 'deleted' => 0, 'payment_status !=' => 0]);

        if(!is_null($date)) {
            $this->db->where(['DATE(order_date)' => $date]);
        }

        return $this->db->get()->num_rows();
    }

    /**
     * Get the sales report.
     * 
     * @param  string $date
     * @return string
     */
    public function getSales($date = null) {
        $this->db->select('SUM(payed_amount) as total');
        $this->db->from('order');
        $this->db->where(['deleted' => 0, 'payment_status !=' => 0]);
        $this->db->where_in('order_status', [1,2,4]);

        if(!is_null($date)) {
            $this->db->where(['DATE(order_date)' => $date]);
        }

        return $this->db->get()->row()->total;
    }
}
