<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->template->title('Page Management');

        $this->data['parent'] = 10;
        $this->data['child'] = 12;

        // Load library
        $this->load->library('form_validation');

        // Load model
        $this->load->model('admin/cms_page_model');
    }

   /**
    * Get all the CMS pages.
    * 
    * @return void
    */
    public function index()
    {
        $this->data['list'] = $this->cms_page_model->get_all();
        
        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
        
        $this->template->build('admin/cms/page/index', $this->data);
    }
  
   /**
    * Create a new page.
    *
    * @return void.
    */
    public function add() 
    {
       
      if ($this->input->post('submit') && $this->input->post('submit') == 'ADD') {
         $this->form_validation->set_rules('name', 'Page Name', 'trim|required|max_length[30]');
         $this->form_validation->set_rules('page_content', 'Page Content', 'trim');
         $this->form_validation->set_rules('page_title', 'Page Title', 'trim|max_length[100]');
         $this->form_validation->set_rules('page_header', 'Page Header', 'trim|max_length[100]');
         $this->form_validation->set_rules('page_url', 'Page Url', 'trim|required|max_length[500]|is_unique[cms_page.url]');
         $this->form_validation->set_rules('301_redirect_url', '301 Redirect Url', 'trim|max_length[500]');
         $this->form_validation->set_rules('canonical_url', 'Canonical Url', 'trim|max_length[500]');
         $this->form_validation->set_rules('301_redirect_status', '301 Redirect Status', 'trim|in_list[0,1]');
         $this->form_validation->set_rules('meta_robot_index', 'Meta Robot Index', 'trim|max_length[10]|in_list[INDEX,NOINDEX]');
         $this->form_validation->set_rules('meta_robot_follow', 'Meta Robot Follow', 'trim|max_length[10]|in_list[FOLLOW,NOFOLLOW]');
         $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|max_length[300]');
         $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim|max_length[300]');
         $this->form_validation->set_rules('status', 'Status', 'trim|in_list[0,1]|required');

         $this->form_validation->set_message('required', 'This field is required');
         $this->form_validation->set_message('is_unique', 'This Url is already taken');
         $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
         
         // Run the validation
         if ($this->form_validation->run() == TRUE) {
             $timestamp = date('Y-m-d H:i:s');
             
             $data = array(
                   'name'               => $this->input->post('name',TRUE),
                   'content'            => $this->input->post('page_content'),
                   'page_header'        => $this->input->post('page_header',TRUE),
                   'url'                => url_title($this->input->post('page_url'), '-', TRUE),
                   '301_redirect_url'   => $this->input->post('301_redirect_url',TRUE),
                   'canonical_url'      => $this->input->post('canonical_url',TRUE),
                   '301_redirect_status' => $this->input->post('301_redirect_status',TRUE),
                   'meta_robots_index'  => $this->input->post('meta_robot_index',TRUE),
                   'meta_robots_follow' => $this->input->post('meta_robot_follow',TRUE),
                   'meta_description'   => $this->input->post('meta_description',TRUE),
                   'meta_keywords'      => $this->input->post('meta_keywords',TRUE),
                   'status'             => $this->input->post('status',TRUE),
                   'type'               => 's',
                   'title'              => $this->input->post('page_title',TRUE),
                   'date_created'       => $timestamp,
                   'date_updated'       => $timestamp
                   
               );
  
                if ($this->cms_page_model->insert($data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_page_saved')));
                }
                else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }
                
                redirect('admin/cms/page');
                exit();
            }
        }
        $this->template->load_asset(array('jquery_upload', 'editor', 'select2', 'dialog'));
        $this->template->build('admin/cms/page/add', $this->data);
    }
    
   /**
    * Get the cms page.
    * 
    * @param  integer $id
    * @return void
    */
    public function edit($id = NULL)
    {
        if (is_null($id) && !is_numeric($id)) {
           show_404();
        }

        $result = $this->cms_page_model->as_array()->get_by(array('page_id' => $id));
        if (empty($result)) {
           show_404();
        }
        
        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('name', 'Page Name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('page_content', 'Page Content', 'trim');
            $this->form_validation->set_rules('page_title', 'Page Title', 'trim|max_length[100]');
            $this->form_validation->set_rules('page_header', 'Page Header', 'trim|max_length[100]');
            $this->form_validation->set_rules('301_redirect_url', '301 Redirect Url', 'trim|max_length[500]');
            $this->form_validation->set_rules('canonical_url', 'Canonical Url', 'trim|max_length[500]');
            $this->form_validation->set_rules('301_redirect_status', '301 Redirect Status', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('meta_robot_index', 'Meta Robot Index', 'trim|max_length[10]|in_list[INDEX,NOINDEX]');
            $this->form_validation->set_rules('meta_robot_follow', 'Meta Robot Follow', 'trim|max_length[10]|in_list[FOLLOW,NOFOLLOW]');
            $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|max_length[300]');
            $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim|max_length[300]');
            $this->form_validation->set_rules('status', 'Status', 'trim|in_list[0,1]|required');

            if($result['type'] == 's') {
                if ($result['url'] == $this->input->post('page_url')) {
                    $this->form_validation->set_rules('page_url', 'Page Url', 'trim|required|max_length[500]');
                } else {
                    $this->form_validation->set_rules('page_url', 'Page Url', 'trim|required|max_length[500]|is_unique[cms_page.url]');
                }
            }
           
            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_message('is_unique', 'This Url is already taken');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
               
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name'              => $this->input->post('name',TRUE),
                    'content'           => $this->input->post('page_content',TRUE),
                    'page_header'       => $this->input->post('page_header',TRUE),
                    '301_redirect_url'  => $this->input->post('301_redirect_url',TRUE),
                    'canonical_url'     => $this->input->post('canonical_url',TRUE),
                    '301_redirect_status' => $this->input->post('301_redirect_status',TRUE),
                    'meta_robots_index' => $this->input->post('meta_robot_index',TRUE),
                    'meta_robots_follow' => $this->input->post('meta_robot_follow',TRUE),
                    'meta_description'   => $this->input->post('meta_description',TRUE),
                    'meta_keywords'      => $this->input->post('meta_keywords',TRUE),
                    'status'             => $this->input->post('status',TRUE),
                    'title'              => $this->input->post('page_title',TRUE),
                    'date_updated'      => date('Y-m-d H:i:s')
                );

                if($result['type'] == 's') {
                    $data['url'] = url_title($this->input->post('page_url'), '-', TRUE);
                }
                
                if ($this->cms_page_model->update($id, $data)) {
                   $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_page_updated')));
                }else {
                   $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/cms/page');
                exit();
            }
        }
        $this->data['page']=$result;
        $this->template->load_asset(array('jquery_upload', 'editor', 'select2', 'dialog'));
        $this->template->build('admin/cms/page/edit', $this->data);
    }

   /**
    * Update the page status.
    * 
    * @return JSON.
    */
    public function status_update()
    {
        if (!$this->input->is_ajax_request()) {
           exit('No direct script access allowed');
        }
        
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
           show_ajax_error('403', lang('error_message_forbidden'));
        }
        
        $id = $this->input->post('id',TRUE);
        $status = $this->input->post('status',TRUE);
        if (empty($id) || empty($status)) {
            show_ajax_error('404', lang('error_message'));
        }
        
        $result = $this->cms_page_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }
        
        $status = ($status == "true") ? 1 : 0;
        if ($this->cms_page_model->update($id, array('status' => $status))) {
            if ($status) {
                set_ajax_flashdata('success', lang('status_enabled'));
            } else {
                set_ajax_flashdata('success', lang('status_disabled'));
            }
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

    /**
     * Delete the page.
     * 
     * @param  integer $id
     * @return void
     */
    public function delete($id = NULL) 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }
        
        if (is_null($id) || !is_numeric($id)) {
            show_ajax_error('404', lang('error_message'));
        }
        
        $result = $this->cms_page_model->as_array()->get_by(array('page_id' => $id));
        
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }
        
        if ($result['type'] == 'd') {
            show_ajax_error('404', lang('error_message'));
        }
        
        if ($this->cms_page_model->delete($id)) {
            set_ajax_flashdata('success', lang('success_page_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

}
