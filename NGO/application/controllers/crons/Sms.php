<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms extends MY_Controller {

    /**
     * Available SMS Gateway classes.
     * @var array
     */
    private $smsGatewayClasses = [
        'twilio'        => 'Twilio',
        'nexmo'         => 'Nexmo',
        'clickatell'    => 'Clickatell'
    ];

    /**
     * SMS object.
     * @var object
     */
    private $smsObject;

    function __construct() {
        parent::__construct();

        // Load model
        $this->load->model('admin/sms_queue_model');

        $this->smsObject = new $this->smsGatewayClasses[Settings::get('sms_gateway')];
    }

    /**
     * Send queued SMS from database.
     * 
     * @return void
     */
    public function index() {
        $result = $this->sms_queue_model->pop();

        if(empty($result)) {
            return true;
        }

        if($this->smsObject->sendTo($result)) {
            $this->sms_queue_model->update($result['id'], ['status' => 1]);
        }else {
            $this->sms_queue_model->update($result['id'], ['failed' => 1]);
        }
    }
}