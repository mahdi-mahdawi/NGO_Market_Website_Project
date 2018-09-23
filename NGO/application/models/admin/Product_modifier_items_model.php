<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_Modifier_Items_Model extends MY_Model
{
    public $_table = 'productes_modifiers_items';
    protected $primary_key = 'id';
    protected $soft_delete = true;
    
    public function __construct()
    {
        parent::__construct();
    }
}
