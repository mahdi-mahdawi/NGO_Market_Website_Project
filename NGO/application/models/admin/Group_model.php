<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_model extends MY_Model {

    public $_table = 'groups';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }
    

}
