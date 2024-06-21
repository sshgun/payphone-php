<?php

namespace sshgun\PayphonePHP;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;

/**
 * @author sshgun
 */
class PayphoneClient
{
    private Client $_http;
    private ?OperationErr $_err;

    public function __construct(string $token, ?Client $httpClient = null)
    {
        $this->_err = null;
        if (is_null($httpClient)) {
            $this->_http = new Client([
                'base_uri' => 'https://pay.payphonetodoesposible.com/api/',
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ],
            ]);
        } else {
            $this->_http = $httpClient;
        }
    }

    public function postPaymentConfirmation(int $id, string $clientId): ?TransactionData
    {
        # TODO: handle errors.
        try {
            $resp = $this->_http->request('POST', 'button/V2/Confirm', [
                'debug' => true,
                'http_errors' => true,
                'json' =>  [
                    'id' => $id,
                    'clientTxId' => $clientId,
                ],
            ]);

            $content = $resp->getBody()->getContents();
            $decoded = json_decode($content, true);
            if ($decoded) {
                return new TransactionData($decoded);
            }
            $this->_err = new OperationErr(0, 'the payphone server return an invalid json for the request');
        } catch (ConnectException $e) {
            # This error indicated a network issue problably the error is one of these
            # 0. commonly is a temporary issue. just try again.
            # 1. You or your server don't have a internet connection.
            # 2. You or your dns server can't resolve the the domain.
            # 3. the PAYPHONE server is down or his domain change.
            $this->_err = new OperationErr(0, $e->getMessage(), $e);
        } catch (BadResponseException $e) {
            $code = 0;
            if ($e->hasResponse()) {
                $code = $e->getResponse()->getStatusCode();
            }
            $this->_err = new OperationErr($code, $e->getMessage(), $e);
        }
        return null;
    }

    public function getError(): ?OperationErr
    {
        return $this->_err;
    }
}
