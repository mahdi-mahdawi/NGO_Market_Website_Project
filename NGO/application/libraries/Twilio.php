<?php

use Services\Twilio as Service;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Twilio implements SMSInterface {

    /**
     * Twilio Account SID.
     * @var string
     */
    private $account_id;

    /**
     * Twilio Auth Token.
     * @var string
     */
    private $auth_token;

    /**
     * Twilio From Number.
     * @var string
     */
    private $from_number;

    function __construct() {
        $this->account_id    = Settings::get('twilio_account_id');
        $this->auth_token    = Settings::get('twilio_auth_token');
        $this->from_number   = Settings::get('twilio_from_number');
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
        $client = new Services_Twilio($this->account_id, $this->auth_token);

        try {

            $message = $client->account->messages->sendMessage(
                $this->from_number,
                $data['to'],
                $data['body']
            );

            return $message->sid;
        }

        catch (Exception $e) {
            return false;
        }
    }
}