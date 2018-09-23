<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

    protected $user_id = NULL;

    function __construct() {
        parent::__construct();

        // Load library
        $this->load->library('auth');

        // Load language files
        $this->lang->load(array('admin', 'dashboard'), 'english');
        
        if (!$this->auth->logged_in()) {
            redirect(base_url('admin/login'));
            exit();
        }

        $this->template->set_layout('admin');

        // Datatable langs
        $this->data['datatable_lang'] = array(
            'lengthMenu'        => lang('lengthMenu'),
            'zeroRecords'       => lang('zeroRecords'),
            'error_mandatory'   => lang('error_mandatory')
        );
        
        $this->template->set('errors', $this->data['datatable_lang']);

        $this->config->load('asset');

        $this->user_id = $this->auth->get_user_id();

        $this->load->library('permission', array('user_id' => $this->user_id));

        $this->data['parent'] = 2;
        $this->data['child'] = 5;
        $this->data['menu'] = 'item';

        $this->template->set_partial('header', 'admin/components/header');
        $this->template->set_partial('sidebar', 'admin/components/sidebar', array('menuList' => $this->permission->menu_array()));
        
        $this->template->set('flashdata', $this->load->view('admin/components/flashdata', '', TRUE));
        $this->template->set('parent', 0);
        $this->template->set('child', 0);
    }

    /**
     * Get the logged in user ID.
     * 
     * @return integer
     */
    protected function get_user_id() {
        return $this->auth->get_user_id();
    }
}
