<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Mailer {

    /**
     * From email address.
     * @var string
     */
    protected $from;

    /**
     * To email address.
     * @var string
     */
    protected $to;

    /**
     * From name.
     * @var string
     */
    protected $from_name;

    function __construct() {
        $email_settings = Settings::get(['admin_from_email', 'admin_from_name', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password']);

        $this->from      = $email_settings['admin_from_email'];
        $this->from_name = $email_settings['admin_from_name'];

        // Load library
        $this->load->library('email');
        $this->load->library('parser');

        // Config
        $config['protocol'] = 'smtp';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $config['smtp_host'] = $email_settings['smtp_host'];
        $config['smtp_user'] = $email_settings['smtp_username'];
        $config['smtp_pass'] = $email_settings['smtp_password'];
        $config['smtp_port'] = $email_settings['smtp_port'];
        
        $this->email->initialize($config);
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Send email with subject and body.
     *
     * @param string $user
     * @param string $subject
     * @param string $view
     * @param Array $data
     * @return boolean.
     */
    public function sendTo($to, $subject, $view, $data = []) {
        $this->email->from($this->from, $this->from_name);
        $this->email->to($to); 

        $this->email->subject($subject);
      
        $this->email->message($this->parseEmailBody($view, $data));  

        return $this->email->send();
    }

    /**
     * Parse the email body.
     * 
     * @param  string $view
     * @param  array  $data
     * @return template
     */
    protected function parseEmailBody($view, $data = []) {
        return $this->parser->parse('emails/' . $view, $data, TRUE);
    }
}