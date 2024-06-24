<?php

namespace sshgun\PayphonePHP;

use JsonSerializable;

/**
 * PreparePaymentArgs is the data object required to send to the Payphone server
 * to prepare a payment with link. the server sill return a URL that should be
 * given to the user to make the payment.
 *
 * @author sshgun
 */
class PreparePaymentArgs implements JsonSerializable
{
    public int $amount;
    public int $amountWithoutTax;
    public string $clientTransactionId;

    public string $responseUrl;
    public string $cancellationUrl;

    /**
     * validateData verify the object data to avoid common errors with transactions.
     */
    public function validateData(): ?OperationErr
    {
        if ($this->amount <= 0) {
            return new OperationErr(
                'the amount is required to prepare the payphone payment, is' .
                    ' missing from your PreparePaymentArgs'
            );
        }

        if (empty($this->responseUrl) || empty($this->cancellationUrl)) {
            return new OperationErr(
                'invalid response or cancellation url, these are needed to' .
                    ' comeback from the payment url, are missing on the ' .
                    ' prepared payment args'
            );
        }

        if (empty($this->clientTransactionId)) {
            return new OperationErr(
                'the clientTransactionId is required to identify your transaction' .
                    ' is missing on your PreparePaymentArgs'
            );
        }
        return null;
    }

    public function jsonSerialize()
    {
        return [
            'amount'                => $this->amount,
            'amountWithoutTax'      => $this->amountWithoutTax,
            'clientTransactionId'   => $this->clientTransactionId,
            'responseUrl'           => $this->responseUrl,
            'cancellationUrl'       => $this->cancellationUrl,
        ];
    }
}
