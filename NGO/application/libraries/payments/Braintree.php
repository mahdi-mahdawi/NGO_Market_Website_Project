<?php

require_once APPPATH . 'third_party/braintree/lib/autoload.php';

class Braintree extends Payment
{
    
    function __construct()
    {   
        parent::__construct();

        Braintree_Configuration::environment(Settings::get('braintree_environment'));
        Braintree_Configuration::merchantId(Settings::get('braintree_merchant_id'));
        Braintree_Configuration::publicKey(Settings::get('braintree_public_key'));
        Braintree_Configuration::privateKey(Settings::get('braintree_private_key'));
    }

    /**
     * Make the transaction.
     * 
     * @param  string $post
     * @param  string $order
     * @return array
     */
    public function makeTransaction($post, $order) {
        $order_reference = $order['order_reference'];

        $transaction = [
            'amount'        => number_format($order['payed_amount'], 2),
            'creditCard'    => [
                'number'         => $post['cardNumber'],
                'cardholderName' => $post['cardholderName'],
                'expirationDate' => $post['expirationDate_month'] . '/' . $post['expirationDate_year'],
                'cvv'            => $post['cvv']
            ],
            'options'       => [ 'submitForSettlement' => true ],
            'orderId'       => $order_reference,
            'billing'       => [
                'firstName'         => $order['first_name'],
                'lastName'          => $order['last_name'],
                'streetAddress'     => $order['address_line_1'],
                'extendedAddress'   => $order['address_line_2'],
                'region'            => $order['city'],
                'postalCode'        => $order['zipcode']
            ],
            'customer'      => [
                'email'             => $order['email'],
                'phone'             => $order['phone']
            ]
        ];

        $result = Braintree_Transaction::sale($transaction);

        // On success
        if($result->success) {
            $this->onSuccess();

            return true;
        }

        else if ($result->transaction) {
            print_r("\n  code: " . $result->transaction->processorResponseCode);
            print_r("\n  text: " . $result->transaction->processorResponseText);
        }

        else {

            $errors = '';

            foreach($result->errors->deepAll() as $error) {
                $errors .= $error->message . "<br/>";
            }

            $this->setMessage($errors);

            return false;
        }
    }
}