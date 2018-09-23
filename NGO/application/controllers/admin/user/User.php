<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->template->title('User Management');

        // Load model
        $this->load->model('admin/user_model');
        $this->load->model('admin/group_model');
        $this->load->model('admin/user_group_model');
        $this->load->model('admin/language_model');

        // Load library
        $this->load->library('form_validation');
        $this->load->library('bcrypt');

        $this->data['parent'] = 26;
        $this->data['child'] = 27;
    }

    public function index() {
        $this->template->load_asset(array('datatable', 'dialog', 'bootstrap_switch'));
       
        $this->data['list'] = $this->user_model->as_array()->get_users(array('user.id !=' => 1));
        $this->template->build('admin/user/user/index', $this->data);
    }

    public function add() {
        if ($this->input->post('submit') && $this->input->post('submit') == 'ADD') {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[50]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|is_unique[user.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[20]');
            $this->form_validation->set_rules('language', 'Language', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $timestamp = date('Y-m-d H:i:s');

                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => $this->bcrypt->hash_password($this->input->post('password')),
                    'phone' => $this->input->post('phone'),
                    'user_language' => $this->input->post('language'),
                    'status' => $this->input->post('status'),
                    'date_created' => $timestamp,
                    'date_updated' => $timestamp
                );

                $user_id = $this->user_model->insert($data);
                if ($this->user_group_model->insert(array('user_id' => $user_id, 'group_id' => 1))) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_user_added')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/user/user');
                exit();
            }
        }

        $this->data['languages'] = $this->language_model->as_array()->get_all();

        $this->template->load_asset(array('select2', 'dialog'));

        $this->template->build('admin/user/user/add', $this->data);
    }

    public function edit($user_id = NULL) {
        if (is_null($user_id) || !is_numeric($user_id)) {
            show_404();
        }

        $result = $this->user_model->as_array()->get_by(array('id' => $user_id));
        if (empty($result)) {
            show_404();
        }

        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[50]');

            if ($this->input->post('email') !== $result['email']) {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|is_unique[user.email]');
            } else {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]');
            }

            $this->form_validation->set_rules('password', 'Password', 'trim|max_length[255]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[20]');
            $this->form_validation->set_rules('language', 'Language', 'trim|required|max_length[5]');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');

            $this->form_validation->set_message('required', 'This field is required');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

            if ($this->form_validation->run()) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'user_language' => $this->input->post('language'),
                    'status' => $this->input->post('status'),
                    'date_updated' => date('Y-m-d H:i:s')
                );

                if ($this->input->post('password')) {
                    $data['password'] = $this->bcrypt->hash_password($this->input->post('password'));
                }

                if ($this->user_model->update($user_id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_user_updated')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                }

                redirect('admin/user/user');
                exit();
            }
        }

        $this->data['languages'] = $this->language_model->as_array()->get_all();
        $this->data['list'] = $this->user_model->as_array()->get_users(array('user.id !=' => 1, 'user.id' => $user_id));

        $this->template->load_asset(array('select2', 'dialog'));

        $this->template->build('admin/user/user/edit', $this->data);
    }

    public function status_update() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if (empty($id) || empty($status)) {
            show_ajax_error('404', lang('error_message'));
        }

        $result = $this->user_model->as_array()->get($id);
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $status = ($status == "true") ? 1 : 0;
        if ($this->user_model->update($id, array('status' => $status))) {
            if ($status) {
                set_ajax_flashdata('success', lang('status_enabled'));
            } else {
                set_ajax_flashdata('success', lang('status_disabled'));
            }
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

    public function delete($user_id = NULL) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            show_ajax_error('403', lang('error_message_forbidden'));
        }

        if (is_null($user_id) || !is_numeric($user_id)) {
            show_ajax_error('404', lang('error_message'));
        }

        $this->load->model('admin/user_group_model');

        $result = $this->user_model->as_array()->get_by(array('id' => $user_id));
        if (empty($result)) {
            show_ajax_error('404', lang('error_message'));
        }

        $this->user_group_model->delete_by(array('user_id' => $user_id));
        if ($this->user_model->delete($user_id)) {
            set_ajax_flashdata('success', lang('success_user_deleted'));
        } else {
            set_ajax_flashdata('error', lang('error_message'));
        }
    }

}
