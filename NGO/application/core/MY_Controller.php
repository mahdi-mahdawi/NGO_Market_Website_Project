<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $data = array();

    /**
     * Global store settings.
     * @var array
     */
    protected $global_settings = array();

    function __construct() {
        parent::__construct();

        // Load library
        $this->load->library('settings');
        
        $this->template->set('token', $this->security->get_csrf_hash());

        // Load configuration values from DB
        $this->settings->load();

        // Global settings
        $this->global_settings = $this->settings->all();

        $this->template->set('global_settings', $this->global_settings);

        date_default_timezone_set($this->settings->get('timezone'));
    }
}
