<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_page_model extends MY_Model {

    public $_table = 'cms_page';
    protected $primary_key = 'page_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }
}
