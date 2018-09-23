<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings {

    private static $configs;

    private $CI;

    function __construct() {

        $this->CI = & get_instance();

        // Load model
        $this->CI->load->model('admin/store_model');
    }

    /**
     * Load config values from DB.
     * 
     * @return void
     */
    public function load() {
       static::$configs = $this->CI->store_model->get_settings();
    }
    
    /**
     * Get the setting value. Accept the either string or []
     * 
     * @param  mixed $key
     * @return mixed
     */
    public static function get($keys = []) {
        if(!is_array($keys)) {
            return self::$configs[$keys];
        }

        $settings = [];
        foreach($keys as $key) {
            $settings[$key] = self::$configs[$key];
        }

        return $settings;
    }

    /**
     * Get all the settings.
     * 
     * @return array
     */
    public function all() {
        static::$configs['store_favicon'] = base_url('uploads/favicon/' . static::$configs['store_favicon']);

        return static::$configs;
    }
}