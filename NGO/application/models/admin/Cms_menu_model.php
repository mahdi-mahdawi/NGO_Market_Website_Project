<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_menu_model extends MY_Model 
{

    public $_table = 'cms_menu';
    protected $primary_key = 'menu_id';
    protected $soft_delete = TRUE;

    public function __construct() 
    {
        parent::__construct();
    }
    
   /**
    * Update all menu order.
    * @param  integer $menus,$parentid
    * @return $menu
    */
     public function updateAllMenuOrders($menus, $parentID) {
        $orderNo = 1;
        foreach ($menus as $menu) {
            $data = array(
                'parent_id' => $parentID,
                'menu_order' => $orderNo++
            );

            $this->db->where('menu_id', $menu->id);
            $this->db->update('cms_menu', $data);

            if (isset($menu->children)) {
                $this->updateAllMenuOrders($menu->children, $menu->id);
            }
        }

        return $menus;
    }

}
