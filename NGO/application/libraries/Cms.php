<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms {

    function __construct() {

        // Load model
        $this->load->model('public/cms_model');
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Get all the CMS menus
     * 
     * @return array
     */
    public function get_all_menus() {
        $all_menus = $this->cms_model->get_all_menus();

        $header_menu = array();
        $footer_menu = array();

        foreach ($all_menus as $row) {
            if ($row['header_menu'] == 1) {
                $header_menu[$row['page_id']]['name'] = $row['menu_name'];
                $header_menu[$row['page_id']]['url'] = $row['page_url'];
            }

            if ($row['footer_menu'] == 1) {
                $footer_menu[$row['page_id']]['name'] = $row['menu_name'];
                $footer_menu[$row['page_id']]['url'] = $row['page_url'];
            }
        }

        return array('header_menus' => $header_menu, 'footer_menus' => $footer_menu);
    }

    /**
     * Get the page data and set data to template variables.
     * 
     * @param  string $page_url
     * @return mixed
     */
    public function get_page($page_url = NULL) {
        if (is_null($page_url)) {
            show_404();
        }

        $page = $this->cms_model->get_page($page_url);
        if (empty($page)) {
            show_404();
        }

        // 301 redirect
        if ($page['301_redirect_status'] == 1 && !empty($page['301_redirect_url'])) {
            redirect($page['301_redirect_url'], 'location', 301);
            exit();
        }

        $this->template->set('meta_title', $page['title']);
        $this->template->set('meta_description', $page['meta_description']);
        $this->template->set('meta_keywords', $page['meta_keywords']);
        $this->template->set('page_header', $page['page_header']);
        $this->template->set('canonical_url', $page['canonical_url']);
        $this->template->set('meta_robots_index', $page['meta_robots_index']);
        $this->template->set('meta_robots_follow', $page['meta_robots_follow']);
        $this->template->set('page_data', $page['content']);

        return true;
    }
}
