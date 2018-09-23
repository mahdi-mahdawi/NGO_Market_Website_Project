<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {

    protected $global_settings = array();

    function __construct() {
        parent::__construct();

        // Load library
        $this->load->library('cms');
        $this->load->library('customer');

        // Load language files
        $this->lang->load(['frontend', 'email', 'form_validation', 'rest_controller'], get_active_language());

        // Get CMS menus
        $menus = $this->cms->get_all_menus();

        $this->template->set_layout('public');
        
        $this->template->set_partial('header', 'public/components/header', array('header_menus' => $menus['header_menus']));
        $this->template->set_partial('footer', 'public/components/footer', array('footer_menus' => $menus['footer_menus']));
        $this->template->set_partial('page_header', 'public/components/page_header', []);

        $customer_logged_in = $this->customer->isLoggedIn();
        $exclude_urls = ($customer_logged_in) ? ['login', 'signup'] : [];

        $this->template->set('exclude_urls', $exclude_urls);
        $this->template->set('customer_logged_in', $customer_logged_in);
        $this->template->set('website_menus', $menus);

        // Maintenance Mode
        if($this->global_settings['maintenance_mode']) {
            show_error('Will right back soon !');
        }

        $this->template->set('languages', config_item('languages'));
    }
}
