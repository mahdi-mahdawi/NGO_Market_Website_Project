<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_Model extends MY_Model
{
    public $_table = 'blog';
    protected $primary_key = 'blog_id';
    protected $soft_delete = TRUE;
 
    public function __construct()
    {
        parent::__construct();
    }
}
