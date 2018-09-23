<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LanguageLoader {

    function initialize() {
        $ci = & get_instance();
        if (empty($ci->uri->segments)) {
            return;
        }
        if ($ci->uri->segments[1] != 'admin') {
            return;
        }


        //load helper
        $ci->load->helper('language');

        //load model
        $ci->load->model('admin/language_model');

        //load library
        $ci->load->library('auth');

        //load language_file
        $ci->language = $ci->language_model->get_user_language(array('user.id' => $ci->auth->get_user_id()));

        if (!file_exists('application/language/' . strtolower($ci->language['name'] . '/dashboard_lang.php'))) {
            $ci->lang->load('dashboard', 'english');
            return;
        }
        //load language
        $ci->lang->load('admin', strtolower($ci->language['name']));
        $ci->lang->load('dashboard', strtolower($ci->language['name']));
    }

}
