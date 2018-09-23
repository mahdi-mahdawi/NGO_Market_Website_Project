<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all the CMS menus
     * 
     * @return array
     */
    public function get_all_menus() {
        $this->db->select(['cms_page.page_id', 'cms_menu.name as menu_name', 'cms_menu.header_menu', 'cms_menu.footer_menu', 'type as page_type', 'url as page_url']);
        $this->db->from('cms_menu');
        $this->db->join('cms_page', 'cms_page.page_id = cms_menu.page_id');
        $this->db->where(['cms_menu.deleted' => 0, 'cms_page.deleted' => 0, 'cms_page.status' => 1]);
        $this->db->order_by('menu_order', 'asc');

        return $this->db->get()->result_array();
    }

    /**
     * Get page details.
     * 
     * @param  string $page_url
     * @return array
     */
    public function get_page($page_url = NULL) {
        $this->db->select(['content', 'page_header', 'page_sub_header', '301_redirect_url', '301_redirect_status', 'canonical_url', 'meta_robots_index', 'meta_robots_follow', 'title', 'meta_description', 'meta_keywords', 'header_image']);
        $this->db->from('cms_page');
        $this->db->where(['deleted' => 0, 'status' => 1, 'url' => strtolower($page_url)]);

        return $this->db->get()->row_array();
    }

}
