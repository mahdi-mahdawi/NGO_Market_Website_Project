<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends MY_Model 
{

    public $_table = 'user';
    protected $primary_key = 'id';

    public function __construct() 
    {
        parent::__construct();
    }

   /**
    * Get all users.
    * @param  integer $condition
    * @return array
    */
    public function get_users($conditions=array()){
        $this->db->select('user.*,groups.name as group_name,groups.id as group_id');
        $this->db->from('user');
        $this->db->join('users_groups','users_groups.user_id=user.id');
        $this->db->join('groups','groups.id=users_groups.group_id');
        if(!empty($conditions)){
            $this->db->where($conditions);
        }
        return $this->db->get()->result_array();
        
    }

}
