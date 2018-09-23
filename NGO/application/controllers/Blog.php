<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        // Load model
        $this->load->model('public/blog_model');

        $this->cms->get_page('blog');
    }

    /**
     * Get all the blog posts.
     * 
     * @return void
     */
    public function index() {
        $this->data['posts'] = $this->blog_model->get_many_by(['status' => 1]);

        $this->template->build('public/blog/index', $this->data);
    }

    /**
     * View the single blog post.
     *
     * @param integer $blog_id
     * @return void
     */
    public function view($blog_id = NULL, $url_slug = NULL) {
        if(is_null($blog_id) || is_null($url_slug) || !is_numeric($blog_id)) {
            show_404();
        }

        $this->data['post'] = $this->blog_model->get_by(['status' => 1, 'blog_id' => $blog_id, 'url_slug' => $url_slug]);

        if(empty($this->data['post'])) {
            show_404();
        }

        $this->template->build('public/blog/view', $this->data);
    } 
}