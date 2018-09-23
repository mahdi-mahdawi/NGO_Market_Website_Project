<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Currency_model extends MY_Model {

    public $_table = 'currency';
    protected $primary_key = 'currency_id';

    public function __construct() {
        parent::__construct();
    }

}
