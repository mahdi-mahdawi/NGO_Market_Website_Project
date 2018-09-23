<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_Modifier_Model extends MY_Model
{
    public $_table = 'productes_modifiers';
    protected $primary_key = 'id';
    protected $soft_delete = true;
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add the modifier.
     *
     * @param [type] $data [description]
     */
    public function addModifier($data)
    {
        $this->db->insert('productes_modifiers', $data);

        return $this->db->insert_id();
    }

    /**
     * Add the product modifier items.
     *
     * @param [type] $data [description]
     */
    public function addModifierItems($data)
    {
        return $this->db->insert_batch('productes_modifiers_items', $data);
    }

    /**
     * Get all the product modifiers for a product.
     *
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function getAllModifiers($condition)
    {
        $this->db->select('DM.id AS modifier_id, DM.name, minimum, maximum');
        $this->db->select('DMI.id AS item_id, DMI.name AS item_name, DMI.price AS item_price');
        $this->db->from('productes_modifiers DM');
        $this->db->join('productes_modifiers_items DMI', 'DMI.modifier_id = DM.id', 'left');
        $this->db->where($condition);

        return $this->db->get()->result();
    }

    /**
     * Update the modifier.
     *
     * @param $productId [<description>]
     * @param [type] $modifierId [<description>]
     * @param [type] $data [description]
     */
    public function updateModifier($productId, $modifierId, $data)
    {
        return $this->db->update('productes_modifiers', $data, array('id' => $modifierId, 'product_id' => $productId));
    }
}