<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Category_Model extends MY_Model {

    public $_table = 'product_category';
    protected $primary_key = 'product_category_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }
}
