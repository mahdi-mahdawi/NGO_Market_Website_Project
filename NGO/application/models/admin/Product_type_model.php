<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_type_model extends MY_Model
{

    public $_table = 'ms_product_type';
    protected $primary_key = 'ms_product_type_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }
}