<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nexmo implements SMSInterface {

    /**
     * Nexmo API Key.
     * @var string
     */
    private $nexmo_api_key;

    /**
     * Nexmo API Secret.
     * @var string
     */
    private $nexmo_api_secret;

    /**
     * Nexmo From Number.
     * @var string
     */
    private $nexmo_from_number;

    function __construct() {
        $this->nexmo_api_key = Settings::get('nexmo_api_key');
        $this->nexmo_api_secret = Settings::get('nexmo_api_secret');
        $this->nexmo_from_number = Settings::get('nexmo_from_number');
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
        $url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
            [
                'api_key' =>  $this->nexmo_api_key,
                'api_secret' => $this->nexmo_api_secret,
                'from' => $this->nexmo_from_number,
                'to' => $data['to'],
                'text' => $data['body']
            ]  
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));

        if($response->messages[0]->status == 0) {
            return true;
        }

        return false;
    }
}