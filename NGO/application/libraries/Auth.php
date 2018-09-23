<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    protected $auth_data = array();

    function __construct() {

        // Load library
        $this->load->library('session');
        $this->load->library('bcrypt');

        // Load model
        $this->load->model('admin/user_model');

        $this->auth_data = $this->session->userdata('admin');
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    // Login
    public function login($email, $password) {
        $result = $this->user_model->get_by(array('email' => $email));

        if (empty($result)) {
            return FALSE;
        }

        if (!$this->bcrypt->check_password($password, $result['password'])) {
            return FALSE;
        }

        if ($result['status'] == 0) {
            return FALSE;
        }

        $this->set_session($result);

        return TRUE;
    }

    protected function set_session($user = array()) {
        if (empty($user)) {
            return FALSE;
        }

        $session_data = array(
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'old_last_login' => $user['last_login']
        );

        $this->session->set_userdata('admin', $session_data);

        // Update last login
        $this->user_model->update($user['id'], array('last_login' => date('Y-m-d H:i:s')));

        return TRUE;
    }

    // Logout
    public function logout() {
        $this->session->unset_userdata('admin');
        return TRUE;
    }

    //Check if the current user is logged in or not
    public function logged_in() {
        if ((isset($this->auth_data['user_id']) && $this->auth_data['user_id']) && (isset($this->auth_data['user_email']) && $this->auth_data['user_email'])) {
            return TRUE;
        }
        return FALSE;
    }

    // Get user id of current logged in user
    public function get_user_id() {
        return isset($this->auth_data['user_id']) ? $this->auth_data['user_id'] : NULL;
    }

    // Get user email of current logged in user
    public function get_user_email() {
        return isset($this->auth_data['user_email']) ? $this->auth_data['user_email'] : NULL;
    }

    // Get the user details
    public function get_user($user_id = NULL) {
        $user_id = (!is_null($user_id)) ? $user_id : $this->get_user_id();

        $result = $this->user_model->get($user_id);
        return !empty($result) ? $result : NULL;
    }
}
