<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings_model extends MY_Model
{
    public $_table = 'store_settings';
    protected $primary_key = 'id';
   
    public function __construct()
    {
        parent::__construct();
    }
    
   /**
    * Get all settings.
    * @param  strings $keys
    * @return array
    */
    public function get_all_settings($keys = []) 
    {
        $this->db->select(array('settings_key', 'settings_value'));
        $this->db->from('store_settings');
        
        if(!empty($keys)) {
          $this->db->where_in('settings_key', $keys);
        }

        $result = $this->db->get()->result_array();
        
        foreach ($result as $key => $row) {
            $settings[$row['settings_key']] = $row['settings_value'];
        }
        
        return $settings;
    }
}
