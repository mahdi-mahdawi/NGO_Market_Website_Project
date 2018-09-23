<?php

class Profile extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('admin/user_model');
        $this->load->model('admin/language_model');

        $this->template->title('MY Account');

        $this->data['parent'] =0;
        $this->data['child'] = 0;
    }

    public function index() {

        //load form validation library
        $this->load->library('form_validation');
        $result = $this->user_model->as_array()->get_by(array('id' => $this->user_id));
        if (empty($result)) {
            show_404();
        }
        if ($this->input->post('submit') && $this->input->post('submit') == 'EDIT') {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[50]|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[50]');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|max_length[20]');
            if ($result['email'] != $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'trim|max_length[100]|required|is_unique[user.email]');
            } else {
                $this->form_validation->set_rules('email', 'Email', 'trim|max_length[100]|required');
            }

            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
            if ($this->form_validation->run()) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'user_language' => $this->input->post('language')
                );

                if ($this->user_model->update($this->user_id, $data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_profile_changed')));
                    redirect('admin/profile');
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                    redirect('admin/profile');
                }
            }
        }
        $this->data['profile'] = $result;
        $this->data['language'] = $this->language_model->as_array()->get_all();

        $this->template->load_asset(array('dialog', 'select2'));

        $this->template->build('admin/profile/index', $this->data);
    }

    public function change_password() {

        //load form validation library
        $this->load->library('form_validation');
        $this->load->library('bcrypt');
        $this->load->library('auth');

        if ($this->input->post('submit') && $this->input->post('submit') == 'CHANGE') {
            $this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required|max_length[255]|callback_check_password');
            $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('conf_pass', 'Confirm Password', 'trim|required|matches[new_pass]');

            $this->form_validation->set_message('required', 'This feild is required');
            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');
            if ($this->form_validation->run()) {
                $password = $this->bcrypt->hash_password($this->input->post('new_pass'));

                if ($this->user_model->update($this->user_id, array('password' => $this->bcrypt->hash_password($this->input->post('new_pass'))))) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_password_changed')));
                    redirect('admin/profile/change_password');
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => lang('error_message')));
                    redirect('admin/profile/change_password');
                }
            }
        }


        $this->template->build('admin/profile/password', $this->data);
    }

    public function check_password() {
        $this->load->library('bcrypt');
        $old_password = $this->input->post('old_pass');
        $user_id = $this->user_id;
        $result = $this->user_model->as_array()->get_by(array('id' => $user_id));
        if (empty($result)) {
            show_404();
        }
        $stored_hash = $result['password'];
        $pass = $this->bcrypt->check_password($old_password, $stored_hash);
        if (!$pass) {
            $this->form_validation->set_message('check_password', 'Please check the Old password');
            return false;
        } else {
            return true;
        }
    }

}
