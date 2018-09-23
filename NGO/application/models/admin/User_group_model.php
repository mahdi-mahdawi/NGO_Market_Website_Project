<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_group_model extends MY_Model {

    public $_table = 'users_groups';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }
    

}
