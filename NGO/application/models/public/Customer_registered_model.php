<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_registered_model extends MY_Model 
{

    public $_table = 'customers_registered';
    protected $primary_key = 'customer_id';
    protected $soft_delete = TRUE;



    public function __construct() 
    {
        parent::__construct();
    }
}
