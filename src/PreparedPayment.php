<?php

namespace sshgun\PayphonePHP;

/**
 * PreparedPayment is the data returned by payphone after prepare a payphone 
 * payment.
 *
 * @author sshgun
 */
class PreparedPayment
{
    /**
     * $paymentId payment identifier returned by Payphone
     */
    public string $paymentId;

    /**
     * $payWithCard URL to wihich you must redirect the user to make the payment
     *  directly with his credit or debit card.
     */
    public string $payWithCard;

    /**
     * $payWithPayPhone URL to which you must redirect the user to make the
     * payment using PayPhone app.
     */
    public string $payWithPayPhone;

    public function __construct(array $data)
    {
        $this->paymentId = $data['paymentId'] ?? '';
        $this->payWithCard = $data['payWithCard'] ?? '';
        $this->payWithPayPhone = $data['payWithPayPhone'] ?? '';
    }
}
