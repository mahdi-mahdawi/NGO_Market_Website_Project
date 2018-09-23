<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->template->set_layout('admin_splash');
    }

    public function page_404() {
        $this->template->build('admin/error/page_404', $this->data);
    }

}
