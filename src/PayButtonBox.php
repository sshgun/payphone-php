<?php

namespace sshgun\PayphonePHP;

/**
 * ButtonData represent the data that can be passed to the PPaymentButtonBox
 *
 * @see https://docs.payphone.app/en/doc/cajita-de-pagos-payphone
 * @author sshgun
 */
class PayButtonBox
{
    /**
     * $token must have the secret token of the PayPhone app.
     */
    public string $token;

    /**
     * $amount represent the total of the transaction. Payphone docs say: 
     *
     * Amount = amountWithoutTax + amountWithTax + Tax + service  + tip
     * all values need to be multiply by 100. ej $1 = 100, $15.67 = 1567
     */
    public int $amount;

    public int $tax;
    public int $tip;
    public int $service;
    public int $amountWithTax;
    public int $amountWithoutTax;

    public string $storeId;
    public string $reference;
    public string $clientTransactionId;

    /**
     * PayphoneButtonData is the data that need to be send to the payphone API
     * use the toJSObject method to pass the data in javascripts or pass it 
     * manually.
     *
     * @param string $token The Payphone app token
     *
     * @param string $tid   The custom id to identify the transactions on your
     *                      application.
     *
     * @param int $amount   The amount of the transaction, the value must be
     *                      multiply by 100 before be send to the API.
     */
    public function __construct(string $token, string $tid,  int $amount)
    {
        $this->token               = $token;
        $this->tax                 = 0;
        $this->tip                 = 0;
        $this->amount              = $amount;
        $this->service             = 0;
        $this->amountWithTax       = 0;
        $this->amountWithoutTax    = $amount;
        $this->storeId             = '';
        $this->reference           = '';
        $this->clientTransactionId = $tid;
    }

    public function renderLoadJS(): string
    {
        $data = $this->toJSObject();

        return '<div id="payphone-container"></div>' .
            '<script>document.addEventListener("DOMContentLoaded", function(){' .
            "(new PPaymentButtonBox($data)).render('payphone-container');" .
            '});</script>';
    }

    /**
     * toJSObject return an string with the javascript object
     */
    public function toJSObject(): string
    {
        return "{
            token: '{$this->token}',
            tax: {$this->tax},
            tip: {$this->tip},
            amount: {$this->amount},
            service: {$this->service},
            amountWithTax: {$this->amountWithTax},
            amountWithoutTax: {$this->amountWithoutTax},
            storeId: '{$this->storeId}',
            reference: '{$this->reference}',
            clientTransactionId: '{$this->clientTransactionId}',
        }";
    }

    public function jsAsset(): string
    {
        return 'https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js';
    }

    public function cssAsset(): string
    {
        return 'https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css';
    }
}
