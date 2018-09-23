<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->template->title('Menu Management');

        //load model
        $this->load->model('admin/cms_page_model');
        $this->load->model('admin/cms_menu_model');

        $this->data['parent'] = 10;
        $this->data['child'] = 11;
    }

    public function index() {
        $this->data['mlist'] = $this->_getAllMenus();
        $this->data['access_edit'] = $this->permission->check_permission(11, 44);
        $this->data['access_delete'] = $this->permission->check_permission(11, 46);

        $this->template->set_partial('add_menu_view', 'admin/cms/menu/add', array('page' => $this->cms_page_model->as_array()->dropdown('name')));

        $this->template->load_asset(array('nestable', 'select2', 'dialog', 'menu_management'));
        $this->template->build('admin/cms/menu/index', $this->data);
    }

    private function _getAllMenus($parentId = 0) {
        $menuList = array();
        $mainMenus = $this->cms_menu_model->order_by('menu_order')->get_many_by(array('parent_id' => $parentId, 'deleted' => 0));

        foreach ($mainMenus as $menu) {
            $menu['subMenu'] = '';
            $subMenu = $this->_getAllMenus($menu['menu_id']);
            if (sizeof($subMenu) > 0) {
                $menu['subMenu'] = $subMenu;
            }
            array_push($menuList, $menu);
        }

        return $menuList;
    }

    public function add() {
        $this->load->library('form_validation');

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('menu', 'Menu', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('page', 'Page To Link', 'trim');
            $this->form_validation->set_rules('header_menu', 'Header Menu', 'trim|in_list[1]');
            $this->form_validation->set_rules('footer_menu', 'Footer Menu', 'trim|in_list[1]');

            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $timestamp = date('Y-m-d H:i:s');

                $basic_menu = array(
                    'page_id' => $this->security->xss_clean($this->input->post('page')),
                    'name' => $this->security->xss_clean($this->input->post('menu')),
                    'header_menu' => ($this->input->post('header_menu')) ? 1 : 0,
                    'footer_menu' => ($this->input->post('footer_menu')) ? 1 : 0,
                    'date_created' => $timestamp,
                    'date_updated' => $timestamp
                );

                if ($this->cms_menu_model->insert($basic_menu)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_menu_saved')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect(base_url('admin/cms/menu'));
            }
        }

        $this->data['mlist'] = $this->_getAllMenus();
        $this->data['pages'] = $this->cms_page_model->get_all();
        $this->data['access_edit'] = $this->permission->check_permission(11, 44);
        $this->data['access_delete'] = $this->permission->check_permission(11, 46);

        $this->template->set_partial('add_menu_view', 'admin/cms/menu/add', array('page' => $this->cms_page_model->as_array()->dropdown('name')));

        $this->template->load_asset(array('nestable', 'dialog', 'select2'));
        $this->template->build('admin/cms/menu/index', $this->data);
    }

    // Update menu orders
    public function updateMenuOrder() {
        if ($this->cms_menu_model->updateAllMenuOrders(json_decode($this->input->post('menuData')), 0)) {
            $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_menu_updated')));
            die(json_encode(array('status' => 1)));
        }
    }

    // Load menu edit form
    public function load_edit_form($menu_id = NULL) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (is_null($menu_id) || !is_numeric($menu_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->cms_menu_model->as_array()->get_by(array('menu_id' => $menu_id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $this->load->library('form_validation');

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('menu', 'Menu', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('page', 'Page To Link', 'trim');
            $this->form_validation->set_rules('header_menu', 'Header Menu', 'trim|in_list[1]');
            $this->form_validation->set_rules('footer_menu', 'Footer Menu', 'trim|in_list[1]');

            $this->form_validation->set_message('required', 'This feild is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run() == FALSE) {
                $data['menu_details'] = $this->cms_menu_model->get_by(array('menu_id' => $menu_id));
                $data['page'] = $this->cms_page_model->as_array()->dropdown('name');
                die(json_encode(array('status' => 0, 'html' => $this->load->view('admin/cms/menu/edit-form', $data, TRUE))));
            }

            $basic_menu = array(
                'page_id' => $this->security->xss_clean($this->input->post('page')),
                'name' => $this->security->xss_clean($this->input->post('menu')),
                'header_menu' => ($this->input->post('header_menu')) ? 1 : 0,
                'footer_menu' => ($this->input->post('footer_menu')) ? 1 : 0,
                'date_updated' => date('Y-m-d H:i:s')
            );

            if ($this->cms_menu_model->update($menu_id, $basic_menu)) {
                $data['page'] = $this->cms_page_model->as_array()->dropdown('name');
                die(json_encode(array('status' => 1, 'html' => $this->load->view('admin/cms/menu/add', $data, TRUE), 'message' => 'Menu Updated')));
            } else {
                set_ajax_flashdata('error', lang('error_message'));
            }
        }

        $data['page'] = $this->cms_page_model->as_array()->dropdown('name');
        $data['menu_details'] = $this->cms_menu_model->get_by(array('menu_id' => $menu_id));

        die(json_encode(array('status' => 1, 'html' => $this->load->view('admin/cms/menu/edit-form', $data, TRUE))));
    }

   
    public function delete($menu_id = NULL) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($menu_id) || !is_numeric($menu_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->cms_menu_model->as_array()->get_by(array('menu_id' => $menu_id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->cms_menu_model->delete($menu_id)) {
            set_ajax_flashdata('success', lang('success_menu_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

}
