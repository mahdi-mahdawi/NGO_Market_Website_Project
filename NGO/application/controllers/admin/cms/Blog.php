<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends Admin_Controller 
{

    function __construct()
     {
        parent::__construct();

        $this->data['parent'] = 10;
        $this->data['child'] = 15;

        $this->template->title('Blog Management');

        // Load model
        $this->load->model('admin/blog_model');

        // Load library
        $this->load->library('form_validation');
        
        // Load helper
        $this->load->helper('text');
    }

    /**
     * Get all blog details.
     * 
     * @return void
     */
    public function index() 
    {
        $this->template->load_asset(array('datatable', 'dialog','bootstrap_switch'));

        $this->data['list'] = $this->blog_model->as_array()->get_all();
        
        $this->template->build('admin/cms/blog/index', $this->data);
    }

    public function add() 
    {
    
        if ($this->input->post('submit') && $this->input->post('submit') == 'ADD') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[1000]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('file_id', 'Image', 'trim|max_length[100]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run() == TRUE) {
                $timestamp = date('Y-m-d H:i:s');

                $data = array(
                    'title' => $this->input->post('title',TRUE),
                    'description' => $this->input->post('description',TRUE),
                    'url_slug' => url_title($this->input->post('title',TRUE)),
                    'status' => $this->input->post('status',TRUE),
                    'image' => $this->input->post('file_id'),
                    'date_created' => $timestamp,
                    'date_updated' => $timestamp
                );

                if ($this->blog_model->insert($data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => config_item('success_blog_saved')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => config_item('error_message')));
                }

                redirect('admin/cms/blog');
                exit();
            }
        }

        // Image upload variables.
        $this->data['upload_folder'] = 'blog';
        $this->data['type'] = 'blog';
        $this->data['thumb_image'] = ($this->input->post('file_id')) ? $this->input->post('file_id') : '';
        $this->data['thumb_image_url'] = ($this->input->post('file_id') && $this->input->post('file_id')) ? base_url('uploads/blog/' . $this->input->post('file_id')) : base_url('assets/admin/images/thumbnail-default.jpg');

        $this->template->load_asset(array('jquery_upload', 'editor'));

        $this->template->build('admin/cms/blog/add', $this->data);
    }

    /**
     * Update the blog.
     * 
     * @param  integer $blog_id
     * @return void
     */
    public function edit($blog_id = NULL)
    {
        $this->load->model('admin/blog_model');

        if (is_null($blog_id) || !is_numeric($blog_id)) {
            show_404();
        }

        $result = $this->blog_model->as_array()->get_by(array('blog_id' => $blog_id));
        if (empty($result)) {
            show_404();
        }
        
        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[1000]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('file_id', 'Image', 'trim|max_length[100]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $this->input->post('title',TRUE),
                    'description' => $this->input->post('description',TRUE),
                    'url_slug' => url_title($this->input->post('title',TRUE)),
                    'status' => $this->input->post('status',TRUE),
                    'image' => $this->input->post('file_id'),
                    'date_updated' => date('Y-m-d H:i:s')
                );
               
                if ($this->blog_model->update($blog_id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_blog_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => config_item('error_message')));
                }

                redirect('admin/cms/blog');
                exit();
            }
        }

        // Image upload variables
        $this->data['upload_folder'] = 'blog';
        $this->data['type'] = 'blog';
        $file_id = ($this->input->post('file_id')) ? $this->input->post('file_id') : $result['image'];
        $this->data['thumb_image'] = ($this->input->post('file_id')) ? $this->input->post('file_id') : $result['image'];
        $this->data['thumb_image_url'] = ($file_id) ? base_url('uploads/blog/thumbs/' . $file_id) : base_url('assets/admin/images/thumbnail-default.jpg');

        $this->data['blog'] = $result;

        $this->template->load_asset(array('jquery_upload', 'editor'));

        $this->template->build('admin/cms/blog/edit', $this->data);
    }
    
   /**
    * Update the blog status.
    * 
    * @return JSON
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

        $result = $this->blog_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->blog_model->update($id, array('status' => $status))) {
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
    * Delete the blog data.
    * 
    * @param  integer $blog_id
    * @return JSON
    */
    public function delete($blog_id = NULL) 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($blog_id) || !is_numeric($blog_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->blog_model->as_array()->get_by(array('blog_id' => $blog_id));
        
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        if ($this->blog_model->delete($blog_id)) {
            set_ajax_flashdata('success', lang('success_blog_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

}
