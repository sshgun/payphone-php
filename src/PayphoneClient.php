<?php

namespace sshgun\PayphonePHP;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;

/**
 * PayphoneClient is a basic client to make request to the payphone payment
 *
 * @author sshgun
 */
class PayphoneClient
{
    private Client $_http;
    private ?OperationErr $_err;

    public function __construct(string $token, ?Client $httpClient = null)
    {
        if (is_null($httpClient)) {
            $httpClient = new Client([
                'base_uri' => 'https://pay.payphonetodoesposible.com/api/',
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ],
            ]);
        }
        $this->_err = null;
        $this->_http = $httpClient;
    }

    /**
     * preparePaymentLinks MAKE A HTTP REQUEST to the payphone server to create
     * the transaction payment links.
     */
    public function preparePaymentLinks(PreparePaymentArgs $data): ?PreparedPayment
    {
        $this->_err = null;
        $err = $data->validateData();
        if (!is_null($err)) {
            $this->_err = $err;
            return null;;
        }

        try {
            $resp = $this->_http->request('POST', 'button/Prepare', [
                'http_errors' => true,
                'json' => $data,
            ]);
            $data = json_decode($resp->getBody()->getContents(), true);
            $preparedPayment = new PreparedPayment($data);
            return $preparedPayment;
        } catch (ConnectException $e) {
            # This error indicated a network issue problably the error is one of these
            # 0. commonly is a temporary issue. just try again.
            # 1. You or your server don't have a internet connection.
            # 2. You or your dns server can't resolve the the domain.
            # 3. the PAYPHONE server is down or his domain change.
            $this->_err = new OperationErr($e->getMessage(), 0, $e);
        } catch (BadResponseException $e) {
            $code = 0;
            if ($e->hasResponse()) {
                $code = $e->getResponse()->getStatusCode();
            }
            $this->_err = new OperationErr($e->getMessage(), $code, $e);
        }
        return null;
    }

    /**
     * @param int    $id        must be the transaction id returned by Payphone.
     *
     * @param string $clientId  Is the client transaction id, you must validate
     *                          that the clientId belong to your system before
     *                          call this function.
     */
    public function postPaymentConfirmation(int $id, string $clientId): ?TransactionData
    {
        $this->_err = null;
        try {
            $resp = $this->_http->request('POST', 'button/V2/Confirm', [
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
            $this->_err = new OperationErr('the payphone server return an invalid json for the request');
        } catch (ConnectException $e) {
            # This error indicated a network issue problably the error is one of these
            # 0. commonly is a temporary issue. just try again.
            # 1. You or your server don't have a internet connection.
            # 2. You or your dns server can't resolve the the domain.
            # 3. the PAYPHONE server is down or his domain change.
            $this->_err = new OperationErr($e->getMessage(), 0, $e);
        } catch (BadResponseException $e) {
            $code = 0;
            if ($e->hasResponse()) {
                $code = $e->getResponse()->getStatusCode();
            }
            $this->_err = new OperationErr($e->getMessage(), $code,  $e);
        }
        return null;
    }

    public function getError(): ?OperationErr
    {
        return $this->_err;
    }
}
