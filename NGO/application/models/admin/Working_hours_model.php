<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Working_Hours_Model extends MY_Model 
{

    public $_table = 'store_hour';
    protected $primary_key = 'id';

    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Update the store working hours.
     * 
     * @param  array  $data
     * @return boolean
     */
    public function update_time($data = array()) {
        $status     = $data['status'];
        $close_hour = $data['close_hour'];

        foreach ($data['open_hour'] as $key => $row) {
            $update = [
                'open_hour'     => $row,
                'close_hour'    => $close_hour[$key],
                'status'        => (!isset($status[$key])) ? 1 : 0
            ];

            $this->db->where('day', $key);
            $this->db->update('store_hour', $update);
        }

        return true;
    }

}
