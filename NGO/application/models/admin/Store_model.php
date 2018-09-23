<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store_model extends MY_Model
{

    public $_table = 'store_settings';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

   /**
    * Get all store settings.
    * @param  null
    * @return array
    */
    public function get_store_settings() 
    {
        $this->db->select(array('settings_key', 'settings_value'));
        $this->db->from('store_settings');
        $result = $this->db->get()->result_array();

        foreach ($result as $key => $row) {
            $settings[$row['settings_key']] = $row['settings_value'];
        }

        return $settings;
    
    }

   /**
    * Update store.
    * @param  variable $data.
    * @return Null.
    */
    public function update_store_settings($data = array())
    {

        $formData = array();

        if (isset($data['store_name'])) {
            array_push($formData, array('settings_key' => 'store_name', 'settings_value' => $data['store_name']));
        }
        if (isset($data['file_id'])) {
            array_push($formData, array('settings_key' => 'store_logo', 'settings_value' => $data['file_id']));
        }
        if (isset($data['file_icon_id'])) {
            array_push($formData, array('settings_key' => 'store_favicon', 'settings_value' => $data['file_icon_id']));
        }
        if (isset($data['store_address'])) {
            array_push($formData, array('settings_key' => 'store_address', 'settings_value' => $data['store_address']));
        }
        if (isset($data['store_phone'])) {
            array_push($formData, array('settings_key' => 'store_phone', 'settings_value' => $data['store_phone']));
        }
        if (isset($data['store_email'])) {
            array_push($formData, array('settings_key' => 'store_email', 'settings_value' => $data['store_email']));
        }
        if (isset($data['store_fax'])) {
            array_push($formData, array('settings_key' => 'store_fax', 'settings_value' => $data['store_fax']));
        }
        if (isset($data['contact_person'])) {
            array_push($formData, array('settings_key' => 'contact_person', 'settings_value' => $data['contact_person']));
        }
        if (isset($data['contact_email'])) {
            array_push($formData, array('settings_key' => 'contact_email', 'settings_value' => $data['contact_email']));
        }
        if (isset($data['contact_number'])) {
            array_push($formData, array('settings_key' => 'contact_number', 'settings_value' => $data['contact_number']));
        }
        if (isset($data['contact_address'])) {
            array_push($formData, array('settings_key' => 'contact_address', 'settings_value' => $data['contact_address']));
        }
        if (isset($data['maintenance_mode'])) {
            array_push($formData, array('settings_key' => 'maintenance_mode', 'settings_value' => $data['maintenance_mode']));
        }
        if (isset($data['google_analytics'])) {
            array_push($formData, array('settings_key' => 'google_analytics', 'settings_value' => $data['google_analytics']));
        }
        if (isset($data['timezone'])) {
            array_push($formData, array('settings_key' => 'timezone', 'settings_value' => $data['timezone']));
        }
        if (isset($data['store_currency'])) {
            array_push($formData, array('settings_key' => 'store_currency', 'settings_value' => $data['store_currency']));
        }
        if (isset($data['store_language'])) {
            array_push($formData, array('settings_key' => 'store_language', 'settings_value' => $data['store_language']));
        }
        if (isset($data['currency_code_position'])) {
            array_push($formData, array('settings_key' => 'currency_code_position', 'settings_value' => $data['currency_code_position']));
        }
        if (isset($data['decimal_places'])) {
            array_push($formData, array('settings_key' => 'decimal_places', 'settings_value' => $data['decimal_places']));
        }
        if (isset($data['use_thousand_seperators'])) {
            array_push($formData, array('settings_key' => 'use_thousand_seperators', 'settings_value' => $data['use_thousand_seperators']));
        }
        if (isset($data['thousand_seperators'])) {
            array_push($formData, array('settings_key' => 'thousand_seperators', 'settings_value' => $data['thousand_seperators']));
        }
        if (isset($data['decimal_separators'])) {
            array_push($formData, array('settings_key' => 'decimal_separators', 'settings_value' => $data['decimal_separators']));
        }

        if ($this->db->update_batch('store_settings', $formData, 'settings_key')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get the store settings.
     * 
     * @param  array  $settings_keys
     * @return array
     */
    public function get_settings($settings_keys = array()) {
        $this->db->select(array('settings_key', 'settings_value'));
        $this->db->from('store_settings');

        if (!empty($settings_keys)) {
            $this->db->where_in('settings_key', $settings_keys);
        }

        $result = $this->db->get()->result_array();

        if (empty($result)) {
            return FALSE;
        }

        foreach ($result as $key => $row) {
            $settings[$row['settings_key']] = $row['settings_value'];
        }

        return $settings;
    }

    /**
     * Get the store working hours.
     * 
     * @return array
     */
    public function get_working_hours() {
        $this->db->select('store_hour.*');
        $this->db->from('store_hour');

        return $this->db->get()->result_array();
    }

    /**
     * Get the store working status.
     * 
     * @param  integer  $day
     * @param  string  $now
     * @return boolean
     */
    public function is_opened($day, $now) {
        $this->db->select('id');
        $this->db->from('store_hour');
        $this->db->where(['day' => $day, 'status' => 1]);
        $this->db->where('open_hour <=', $now);
        $this->db->where('close_hour >=', $now);

        $result = $this->db->get()->row();
        return (empty($result)) ? false : true;
    }

}