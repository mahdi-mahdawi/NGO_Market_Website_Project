<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group_Access_Model extends MY_Model {

    public $_table = 'group_access';
    protected $primary_key = 'group_access_id';

    public function __construct() {
        parent::__construct();
    }

}
