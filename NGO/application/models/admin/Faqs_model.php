<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faqs_model extends MY_Model 
{
    public $_table = 'faqs';
    protected $primary_key = 'id';
    protected $soft_delete = TRUE;

    public function __construct() 
    {
        parent::__construct();
    }

}
