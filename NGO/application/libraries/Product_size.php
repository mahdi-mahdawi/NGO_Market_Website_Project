<?php 

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_size
{
    public function __construct()
    {
        // Load model
        $this->load->model('admin/size_model');
        $this->load->model('admin/product_sizes_model');
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
     * Add different sizes items.
     *
     * @param integer $productId      [description]
     * @param array $items      [description]
     */
    public function addDifferentSizes($productId, $items)
    {
        if (empty($items) || is_null($productId)) {
            return false;
        }

        $data = [
            'product_id' => $productId,
            'size_id' => $items['size'],
            'price'   => $items['size_price']
        ];
        
        return $this->product_sizes_model->insert($data);
    }

    /**
     * Get all the sies for a product.
     *
     * @param  [type] $productId [description]
     * @return [type]         [description]
     */
    public function getAllSizes($productId)
    {
        $condition = [
            'product_sizes.product_id' => $productId
        ];

        return $this->product_sizes_model->getAllSizes($condition);
    }

    /**
     * Update the product sizes.
     *
     * @param [type] $productId [description]
     * @param [type] $productSizeId [description]
     * @param [type] $post   [description]
     * @return [type]        [<description>]
     */
    public function updateSizes($productId, $productSizeId, $post)
    {
        if (empty($this->product_sizes_model->get_by(array('product_id' => $productId , 'id' => $productSizeId)))) {
            return false;
        }
        
        $result = $this->product_sizes_model->update($productSizeId, $post);
               
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete the product sizes.
     *
     * @param  [type] $productId     [description]
     * @param  [type] $productSizeId [description]
     * @return [type]             [description]
     */
    public function deleteproductSize($productId, $productSizeId)
    {
        if ($this->product_sizes_model->delete_by(array('product_id' => $productId, 'id' => $productSizeId))) {
            return true;
        } else {
            return false;
        }
    }
    
}
