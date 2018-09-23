<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('auth');
    }

    public function index() {
        $this->auth->logout();

        redirect(base_url('admin/login'));
        exit();
    }

}
