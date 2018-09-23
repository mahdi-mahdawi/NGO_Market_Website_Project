<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms {

    /**
     * Available SMS Gateway classes.
     * @var array
     */
    private $smsGatewayClasses = [
        'twilio'    => 'Twilio',
        'nexmo'     => 'Nexmo',
        'clickatell' => 'Clickatell'
    ];

    /**
     * SMS object.
     * @var object
     */
    private $smsObject;

    /**
     * Do we need push to queue ?
     * @var boolean
     */
    private $queuing;

    function __construct() {
        $this->smsObject = new $this->smsGatewayClasses[Settings::get('sms_gateway')];

        $this->queuing = false;

        // Load model
        $this->load->model('admin/sms_queue_model');

        // Load library
        $this->load->library('parser');
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Send SMS.
     * 
     * @param  array            $data
     * @param  SMSInterface|null $sms
     * @return boolean
     */
    public function sendTo($data, $template, $to, SMSInterface $sms = null) {
        $sms = ($sms) ?: $this->smsObject;

        $post['body'] = $this->parseSmsBody($template, $data);
        $post['to'] = $to;

        ($this->queuing) ? $this->pushToQueue($post) : $sms->sendTo($post);

        return true;
    }

    /**
     * Push SMS to database queue.
     * 
     * @param  array $data
     * @return void
     */
    public function pushToQueue($data) {
        $this->sms_queue_model->push($data);
    }

    /**
     * Parse the email body.
     * 
     * @param  string $view
     * @param  array  $data
     * @return template
     */
    protected function parseSmsBody($template, $data = []) {
        return $this->parser->parse_string($template, $data, TRUE);
    }
}