<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * get a single module
     * 
     */

    public function getModule($select = array(), $where = array()) {
        $this->db->select($select);
        $this->db->from("modules");
        $this->db->where("modules.status = 1");
        $this->db->where($where);
        $result = $this->db->get();
        return $result->row_array();
    }

    /*
     * get all modules and access rights
     * 
     */

    public function getAllModules($select = array(), $where = array()) {
        $this->db->select($select);
        $this->db->from("modules");
        $this->db->join("module_access", "modules.module_id = module_access.module_id AND module_access.status = 1");
        $this->db->where("modules.status = 1");
        $this->db->where($where);
        $result = $this->db->get();
        return $result->result_array();
    }

    /*
     * get all modules with access rights and users
     * 
     */

    public function getAllModulesWithUserAccess($select = array(), $where = array()) {
        $this->db->select($select);
        $this->db->from("modules");
        $this->db->join("module_access", "modules.module_id = module_access.module_id AND module_access.status = 1");
        $this->db->join("users_access", " module_access.module_id = users_access.access_id AND users_access.status = 1 ");
        $this->db->join("users", " users.id = users_access.user_id AND users.active = 1");
        $this->db->where("modules.status = 1");
        $this->db->where($where);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function getUserModules($user_id) {
        $query1 = "(SELECT modules.module_id, modules.module_name, modules.module_desc, modules.parent_id, modules.show_menu, modules.url, "
                . "modules.menu_order, modules.menu_css, module_access.access_id, module_access.access_name, module_access.show_to_all "
                . "FROM modules JOIN module_access ON module_access.module_id = modules.module_id AND module_access.status = 1 "
                . "WHERE module_access.show_to_all = 1 AND modules.status = 1)";
        $query2 = "(SELECT modules.module_id, modules.module_name, modules.module_desc, modules.parent_id, modules.show_menu, modules.url, "
                . "modules.menu_order, modules.menu_css, module_access.access_id, module_access.access_name, module_access.show_to_all "
                . "FROM modules JOIN module_access ON module_access.module_id = modules.module_id AND module_access.status = 1 "
                . "JOIN users_access ON module_access.access_id = users_access.access_id AND users_access.status = 1 "
                . "JOIN user ON user.id = users_access.user_id AND user.status = 1 "
                . "WHERE modules.status = 1 AND user.id = $user_id) ";
        $query3 = "(SELECT modules.module_id, modules.module_name, modules.module_desc, modules.parent_id, modules.show_menu, modules.url, "
                . "modules.menu_order, modules.menu_css, module_access.access_id, module_access.access_name, module_access.show_to_all "
                . "FROM modules JOIN module_access ON module_access.module_id = modules.module_id AND module_access.status = 1 "
                . "JOIN group_access ON module_access.access_id = group_access.access_id AND group_access.status = 1 AND group_access.deleted = 0 "
                . "JOIN groups ON groups.id = group_access.group_id AND group_access.status = 1 "
                . "JOIN users_groups ON users_groups.group_id = groups.id "
                . "WHERE modules.status = 1 AND users_groups.user_id = $user_id )";
        $query = $query1 . " UNION " . $query2 . " UNION " . $query3 . " ORDER BY menu_order";
        $result = $this->db->query($query);
        return $result->result_array();
    }

}
