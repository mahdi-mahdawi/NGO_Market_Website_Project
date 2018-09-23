<?php 

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_modifiers
{
    public function __construct()
    {
        // Load model
        $this->load->model('admin/product_modifier_model');
        $this->load->model('admin/product_modifier_items_model');
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
     * Add the product modifier.
     *
     * @param [type] $productId [description]
     * @param [type] $post   [description]
     */
    public function addModifier($productId, $post)
    {
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'product_id' => $productId,
            'name' => $post['name'],
            'minimum' => $post['minimum'],
            'maximum' => $post['maximum'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        $modifierId = $this->product_modifier_model->addModifier($data);

        $items = [
            'names' => isset($post['item_name']) ? $post['item_name'] : [],
            'prices' => isset($post['item_price']) ? $post['item_price'] : [],
        ];

        $this->addModifierItems($modifierId, $items);

        return $modifierId;
    }

    /**
     * Add the product modifier items.
     *
     * @param [type] $modifierId [description]
     * @param [type] $items      [description]
     */
    public function addModifierItems($modifierId, $items)
    {
        if (empty($items)) {
            return false;
        }

        for ($i = 0; $i < count($items['names']); $i++) {
            $data[] = [
                'modifier_id' => $modifierId,
                'name' => $items['names'][$i],
                'price' => $items['prices'][$i]
            ];
        }

        return $this->product_modifier_model->addModifierItems($data);
    }

    /**
     * Get all the modifiers for a product.
     *
     * @param  [type] $productId [description]
     * @return [type]         [description]
     */
    public function getAllModifiers($productId)
    {
        $condition = [
            'product_id' => $productId,
            'DM.deleted' => 0,
            'DMI.deleted' => 0
        ];

        return transformproductModifiers($this->product_modifier_model->getAllModifiers($condition));
    }

    /**
     * Get a product modifier.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $modifierId [description]
     * @return [type]             [description]
     */
    public function getModifier($productId, $modifierId)
    {
        $condition = [
            'DM.id' => $modifierId,
            'product_id' => $productId,
            'DM.deleted' => 0,
            'DMI.deleted' => 0
        ];

        $result = transformproductModifiers($this->product_modifier_model->getAllModifiers($condition));

        return !empty($result) ? $result[$modifierId] : [];
    }

    /**
     * Delete the product modifier.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $modifierId [description]
     * @return [type]             [description]
     */
    public function deleteModifier($productId, $modifierId)
    {
        $result1 = $this->product_modifier_model->delete_by(array('id' => $modifierId, 'product_id' => $productId));
        $result2 = $this->product_modifier_items_model->delete_by(array('modifier_id' => $modifierId));
       
        if ($result1 && $result2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update the product modifier.
     *
     * @param [type] $productId [description]
     * @param [type] $modifierId [description]
     * @param [type] $post   [description]
     */
    public function updateModifier($productId, $modifierId, $post)
    {
        $condition = [
            'DM.id' => $modifierId,
            'product_id' => $productId,
            'DM.deleted' => 0,
            'DMI.deleted' => 0
        ];

        if (empty($this->product_modifier_model->getAllModifiers($condition))) {
            return false;
        }
        
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'name' => $post['name'],
            'minimum' => $post['minimum'],
            'maximum' => $post['maximum'],
            'updated_at' => $timestamp
        ];

        $result1 = $this->product_modifier_model->updateModifier($productId, $modifierId, $data);

        $items = [
            'names' => isset($post['item_name']) ? $post['item_name'] : [],
            'prices' => isset($post['item_price']) ? $post['item_price'] : [],
        ];

        $result2 = $this->updateModifierItems($modifierId, $items);

        if ($result1 && $result2) {
            return true;
        } else {
            return false;
        }
    }

     /**
     * Update the product modifier items.
     *
     * @param [type] $modifierId [description]
     * @param [type] $items      [description]
     */
    public function updateModifierItems($modifierId, $items)
    {
        if (empty($items)) {
            return false;
        }

        $this->product_modifier_items_model->delete_by(array('modifier_id' => $modifierId));

        for ($i = 0; $i < count($items['names']); $i++) {
            $data[] = [
                'modifier_id' => $modifierId,
                'name' => $items['names'][$i],
                'price' => $items['prices'][$i]
            ];
        }

        return $this->product_modifier_model->addModifierItems($data);
    }
}
