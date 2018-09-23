<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Model extends MY_Model {

    public $_table = 'modules';
    protected $primary_key = 'module_id';
    protected $soft_delete = TRUE;

    public function __construct() {
        parent::__construct();
    }

    public function get_access($conditions = array()) {
        $this->db->select('modules.*,module_access.access_id,module_access.access_name');
        $this->db->from('modules');

        $this->db->join('module_access', 'module_access.module_id=modules.module_id');
        $this->db->join('group_access', 'module_access.access_id=group_access.access_id', 'left');
        $this->db->join('groups', 'groups.id=group_access.group_id');
       // $this->db->join('users_groups', 'users_groups.group_id=groups.id');

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        return $this->db->get()->result_array();
    }

    public function get_modules($conditions = array()) {
        $this->db->select('modules.*,module_access.access_id,module_access.access_name');
        $this->db->from('modules');

        $this->db->join('module_access', 'module_access.module_id=modules.module_id','left');
        //$this->db->join('group_access', 'group_access.module_id=modules.module_id','right outer');

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        return $this->db->get()->result_array();
    }

}
