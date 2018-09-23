<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Size_Model extends MY_Model
{
    public $_table = 'sizes';
    protected $primary_key = 'id';
       
    public function __construct()
    {
        parent::__construct();
    }
}
