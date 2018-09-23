<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store_Model extends MY_Model {

    public $_table = 'store_settings';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }
}
