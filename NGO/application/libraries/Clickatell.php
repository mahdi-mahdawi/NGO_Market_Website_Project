<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Clickatell\Api\ClickatellHttp;

class Clickatell implements SMSInterface {

    /**
     * Clickatell Username.
     * @var string
     */
    private $clickatell_username;

    /**
     * Clickatell Password.
     * @var string
     */
    private $clickatell_password;

    /**
     * Clickatell API ID.
     * @var string
     */
    private $clickatell_api_key;

    /**
     * Clickatell From Number.
     * @var string
     */
    private $clickatell_from_number;

    function __construct() {
        $this->clickatell_username = Settings::get('clickatell_username');
        $this->clickatell_password = Settings::get('clickatell_password');
        $this->clickatell_api_key = Settings::get('clickatell_api_key');
        $this->clickatell_from_number = Settings::get('clickatell_from_number');
    }

    // Enables the use of CI super-global without having to define an extra variable.
    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Send SMS.
     * 
     * @param  array $data
     * @return boolean
     */
    public function sendTo($data) {
        $clickatell = new ClickatellHttp($this->clickatell_username, $this->clickatell_password, $this->clickatell_api_key); 
        
        $response = $clickatell->sendMessage($data['to'], $data['body']);

        foreach ($response as $message) {
            if($message->id) {
                return true;
            }
        }

        return false;
    }
}