<?php

use Omnipay\Omnipay;

class Stripe extends Payment
{   

    /**
     * Secret key.
     * @var string
     */
    private $secret_key;

    /**
     * Publishable key.
     * @var string
     */
    private $publishable_key;

    /**
     * Gateway object.
     * @var string
     */
    private $gateway;
    
    function __construct()
    {   
        parent::__construct();

        $this->secret_key = Settings::get('stripe_secret_key');
        $this->publishable_key = Settings::get('stripe_publishable_key');

        $this->gateway    = Omnipay::create('Stripe');
    }

    /**
     * Make the transaction.
     * 
     * @param  string $post
     * @param  string $order
     * @return array
     */
    public function makeTransaction($post, $order) {
        $this->gateway->setApiKey($this->secret_key);
            
        $request = [
            'amount'        => number_format($order['payed_amount'], 2), 
            'currency'      => $this->store_currency,
            'token'         => $post['stripe_token']
        ];

        try {
            $response = $this->gateway->purchase($request)->send();

            // On success
            if ($response->isSuccessful()) {
                $this->onSuccess();

                return true;
            }

            // On error
            else{
                $this->setMessage($response->getMessage());

                return false;
            }
        }

        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Get the publishable key.
     * 
     * @return string
     */
    public function getPublishableKey() {
        return $this->publishable_key;
    }
}