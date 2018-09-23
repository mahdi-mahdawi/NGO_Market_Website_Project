<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language extends Frontend_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Language switch.
     *
     * @param string $language_key
     * @return void
     */
    public function index($language_key = null) {
        if(is_null($language_key)) {
            show_404();
        }

        $languages = config_item('languages');

        if(!isset($languages[$language_key])) {
            show_404();
        }

        // Set the language key in session.
        $this->session->set_userdata('language', $language_key);

        if(isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }

        redirect('home', 'refresh');
        exit();
    }
}
