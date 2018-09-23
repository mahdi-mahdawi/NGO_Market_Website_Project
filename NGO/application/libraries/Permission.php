<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission {

    protected $admin_menu = array();
    protected $access_rights = array();

    function __construct($params) {
        $this->load->model('admin/permission_model');

        $this->format_rights($this->permission_model->getUserModules($params['user_id']));
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    private function format_rights($access_rights) {
        foreach ($access_rights as $key => $value) {
            $this->access_rights[$value['module_id']][$value['access_id']] = $value;

            if ($value['show_menu'] == 1) {
                if ($value['parent_id'] == 0) {
                    //setting parent
                    $this->admin_menu[$value['module_id']]['name'] = $value['module_name'];
                    $this->admin_menu[$value['module_id']]['css'] = $value['menu_css'];
                    $this->admin_menu[$value['module_id']]['url'] = $value['url'];
                } else {
                    if (isset($this->admin_menu[$value['parent_id']])) {
                        //setting child
                        $this->admin_menu[$value['parent_id']]['sub_menu'][$value['module_id']]['name'] = $value['module_name'];
                        $this->admin_menu[$value['parent_id']]['sub_menu'][$value['module_id']]['css'] = $value['menu_css'];
                        $this->admin_menu[$value['parent_id']]['sub_menu'][$value['module_id']]['url'] = $value['url'];
                    } else {
                        $parent = $this->permission_model->getModule(array(), array('module_id' => $value['parent_id']));

                        //setting parent
                        $this->admin_menu[$parent['module_id']]['name'] = $parent['module_name'];
                        $this->admin_menu[$parent['module_id']]['css'] = $parent['menu_css'];
                        $this->admin_menu[$parent['module_id']]['url'] = $parent['url'];

                        //setting child
                        $this->admin_menu[$parent['module_id']]['sub_menu'][$value['module_id']]['name'] = $value['module_name'];
                        $this->admin_menu[$parent['module_id']]['sub_menu'][$value['module_id']]['css'] = $value['menu_css'];
                        $this->admin_menu[$parent['module_id']]['sub_menu'][$value['module_id']]['url'] = $value['url'];
                    }
                }
            }
        }
    }

    public function check_permission($module_id = NULL, $access_id = NULL) {
        return (isset($this->access_rights[$module_id][$access_id])) ? TRUE : FALSE;
    }

    public function check_permission_404($module_id = NULL, $access_id = NULL) {
        if (!isset($this->access_rights[$module_id][$access_id])) {
            show_404();
        }
    }

    public function check_permission_ajax($module_id = NULL, $access_id = NULL) {
        if (!isset($this->access_rights[$module_id][$access_id])) {
            show_ajax_error('403', lang('error_message_no_permission'));
        }

        return TRUE;
    }

    public function menu_array() {
        return $this->admin_menu;
    }

}
