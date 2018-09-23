<?php


if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customer
{
    /**
     * Customer ID.
     *
     * @var int
     */
    private $customer_id;

    /**
     * Customer email.
     *
     * @var string
     */
    private $customer_email;

    /**
     * Logged in status.
     *
     * @var bool
     */
    private $logged_in;

    public function __construct()
    {

        // Load library
        $this->load->library('bcrypt');

        // Load model
        $this->load->model('public/customer_model');
        $this->load->model('public/customer_registered_model');
        $this->load->model('public/order_model');
        $this->load->model('public/customer_registered_model');

        $this->initialize();
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function initialize()
    {
        // Get customer session data
        $session_data = $this->session->userdata('customer');

        if (isset($session_data['customer_id']) && isset($session_data['email']) && $session_data['logged_in']) {
            $this->customer_id = $session_data['customer_id'];
            $this->customer_email = $session_data['email'];
            $this->logged_in = $session_data['logged_in'];
        }
    }

    /**
     * Get the current logged in customer ID.
     * 
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Check the customer is logged in or not ?
     * 
     * @return bool
     */
    public function isLoggedIn()
    {
        if (isset($this->customer_id) && isset($this->customer_email) && isset($this->logged_in)) {
            return true;
        }

        return false;
    }

    /**
     * Signup the customer.
     * 
     * @param array $post
     *
     * @return bool
     */
    public function signup($post = [])
    {
        $post['password'] = $this->bcrypt->hash_password($post['password']);

        if ($this->customer_model->signupCustomer($post)) {
            return true;
        }

        return false;
    }

    /**
     * Get the customer profile.
     * 
     * @param int $customer_id
     *
     * @return array
     */
    public function getCustomer($customer_id = null)
    {
        $customer_id = ($customer_id) ? $customer_id : $this->customer_id;

        return $this->customer_model->getCustomer(['customers_registered.customer_id' => $customer_id]);
    }

    /**
     * Is the customer exist with given email ID ?
     * 
     * @param string $email
     *
     * @return bool
     */
    public function isExist($email)
    {
        $customer = $this->customer_model->getCustomer(['email' => $email]);

        return empty($customer) ? false : true;
    }

    /**
     * Customer login.
     * 
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function login($email, $password)
    {
        $result = $this->customer_model->getCustomer(['email' => $email]);

        if (empty($result)) {
            return false;
        }

        if (!$this->bcrypt->check_password($password, $result['password'])) {
            return false;
        }

        $this->setSession(['customer_id' => $result['customer_id'], 'email' => $result['email'], 'logged_in' => true]);

        return true;
    }

    /**
     * Set the customer session.
     *
     * @param array $customer
     */
    private function setSession($customer)
    {
        $this->session->set_userdata('customer', $customer);
    }

    /**
     * Signout the customer session.
     * 
     * @return bool
     */
    public function logout()
    {
        $this->session->unset_userdata('customer');

        $this->customer_id = null;
        $this->customer_email = null;
        $this->logged_in = null;

        return true;
    }

    /**
     * Update the customer profile.
     *
     * @param array $profile
     *
     * @return bool
     */
    public function updateProfile($profile)
    {
        $customer = [
            'first_name' => $profile['first_name'],
            'last_name' => $profile['last_name'],
            'city' => $profile['city'],
            'zipcode' => $profile['zipcode'],
            'phone' => $profile['mobile'],
            'date_updated' => date('Y-m-d H:i:s'),
        ];

        return $this->customer_model->update_by(['customer_id' => $this->customer_id], $customer);
    }

    /**
     * Redirect URL after login or signup.
     * 
     * @return string
     */
    public function redirectTo()
    {
        if ($this->session->userdata('cart_contents')) {
            return base_url('checkout');
        }

        return base_url('account');
    }

    /**
     * Is the customer exist with given customer ID.
     * 
     * @param int $customerID
     *
     * @return bool
     */
    public function isCustomerExist($customerID)
    {
        $customer = $this->customer_model->getCustomerID(['customer_id' => $customerID]);

        return empty($customer) ? false : true;
    }

    /**
     * Update the customer password.
     *
     * @param int   $customer_id.
     * @param array $param
     *
     * @return JSON
     */
    public function updatePassword($param = [], $customer_id)
    {
        $password = $this->bcrypt->hash_password($param['password']);

        if ($param['password_reset_token'] == null) {
            $password_reset_token = null;
            $token_created = null;
        }

        return $this->customer_registered_model->update($customer_id, array('password' => $password, 'password_reset_token' => $password_reset_token, 'token_created' => $token_created));
    }

    /**
     * Customer check old password.
     *
     * @param int    $customer_id
     * @param string $old_password
     *
     * @return boolean.
     */
    public function checkOldpassword($old_password, $customer_id)
    {
        $result = $this->customer_registered_model->as_array()->get_by(array('customer_id' => $customer_id));

        if (empty($result)) {
            show_404();
        }

        $stored_hash = $result['password'];

        $pass = $this->bcrypt->check_password($old_password, $stored_hash);

        if (!$pass) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get Customer details.
     * 
     * @param string $email
     *
     * @return array
     */
    public function getCustomerByEmail($email)
    {
        $result = $this->customer_model->getCustomer(['email' => $email]);

        if (empty($result)) {
            return false;
        }

        return $result;
    }

    /**
     * Set customer password token.
     * 
     * @param int $customer_id.
     *
     * @return JSON
     */
    public function createPasswordToken($customer_id)
    {
        $random_digit = mt_rand(1058, 9989);
        $salt = hash('sha512', $random_digit.$customer_id);
        $timestamp = date('Y-m-d H:i:s');

        return $this->customer_registered_model->update_by(array('customer_id' => $customer_id), array('password_reset_token' => $salt, 'token_created' => $timestamp));
    }

    /**
     * Get token expiry.
     * 
     * @param string $token.
     *
     * @return JSON
     */
    public function isExistPasswordToken($token)
    {
        $result = $this->customer_registered_model->get_by(array('password_reset_token' => $token));

        if (empty($result)) {
            return false;
        }

        $expiry_limit = round((strtotime(date('Y-m-d H:i:s')) - strtotime($result['token_created'])) / 60);

        if ($expiry_limit > 15) {
            return false;
        }

        return $result;
    }
}
