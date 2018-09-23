<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language_model extends MY_Model
 {

    public $_table = 'language';
    protected $primary_key = 'language_id';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all user language.
     * @param  integer $condition
     * @return array
     */
    public function get_user_language($conditions = array()) 
    {
    
        $this->db->select('language.name,language.code as lang_code,user.id as user_id');
        $this->db->from('language');
        $this->db->join('user', 'user.user_language=language.code');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        return $this->db->get()->row_array();
    
    }

}
