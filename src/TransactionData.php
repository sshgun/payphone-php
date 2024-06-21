<?php

namespace sshgun\PayphonePHP;

class TransactionData
{
    private string $cardType;
    private string $deferredCode;
    private string $deferredMessage;
    private bool $deferred;
    private float $amount;
    private string $clientTransactionId;
    private int $statusCode;
    private string $transactionStatus;
    private string $authorizationCode;
    private string $message;
    private int $messageCode;
    private int $transactionId;
    private array $taxes;
    private string $currency;
    private ?string $optionalParameter1;
    private ?string $optionalParameter2;
    private ?string $optionalParameter3;
    private ?string $optionalParameter4;
    private string $storeName;
    private string $date;
    private string $regionIso;
    private string $transactionType;
    private ?string $recap;
    private string $reference;

    public function __construct(array $data = [])
    {

        $this->cardType             = (string) ($data['cardType'] ?? '');
        $this->deferredCode         = (string) ($data['deferredCode'] ?? '');
        $this->deferredMessage      = (string) ($data['deferredMessage'] ?? '');
        $this->deferred             = (bool) ($data['deferred'] ?? false);
        $this->amount               = (float) ($data['amount'] ?? 0.0);
        $this->clientTransactionId  = (string) ($data['clientTransactionId'] ?? '');
        $this->statusCode           = (int) ($data['statusCode'] ?? 0);
        $this->transactionStatus    = (string) ($data['transactionStatus'] ?? '');
        $this->authorizationCode    = (string) ($data['authorizationCode'] ?? '');
        $this->message              = (string) ($data['message'] ?? '');
        $this->messageCode          = (int) ($data['messageCode'] ?? 0);
        $this->transactionId        = (int) ($data['transactionId'] ?? 0);
        $this->taxes                = isset($data['taxes']) && is_array($data['taxes']) ? $data['taxes'] : [];
        $this->currency             = (string) ($data['currency'] ?? '');
        $this->optionalParameter1   = isset($data['optionalParameter1']) ? (string) $data['optionalParameter1'] : null;
        $this->optionalParameter2   = isset($data['optionalParameter2']) ? (string) $data['optionalParameter2'] : null;
        $this->optionalParameter3   = isset($data['optionalParameter3']) ? (string) $data['optionalParameter3'] : null;
        $this->optionalParameter4   = isset($data['optionalParameter4']) ? (string) $data['optionalParameter4'] : null;
        $this->storeName            = (string) ($data['storeName'] ?? '');
        $this->date                 = (string) ($data['date'] ?? '');
        $this->regionIso            = (string) ($data['regionIso'] ?? '');
        $this->transactionType      = (string) ($data['transactionType'] ?? '');
        $this->recap                = isset($data['recap']) ? (string) $data['recap'] : null;
        $this->reference            = (string) ($data['reference'] ?? '');
    }

    public function getCardType(): string
    {
        return $this->cardType;
    }

    public function getDeferredCode(): string
    {
        return $this->deferredCode;
    }

    public function getDeferredMessage(): string
    {
        return $this->deferredMessage;
    }

    public function isDeferred(): bool
    {
        return $this->deferred;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getClientTransactionId(): string
    {
        return $this->clientTransactionId;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getTransactionStatus(): string
    {
        return $this->transactionStatus;
    }

    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getMessageCode(): int
    {
        return $this->messageCode;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function getTaxes(): array
    {
        return $this->taxes;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getOptionalParameter1(): ?string
    {
        return $this->optionalParameter1;
    }

    public function getOptionalParameter2(): ?string
    {
        return $this->optionalParameter2;
    }

    public function getOptionalParameter3(): ?string
    {
        return $this->optionalParameter3;
    }

    public function getOptionalParameter4(): ?string
    {
        return $this->optionalParameter4;
    }

    public function getStoreName(): string
    {
        return $this->storeName;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getRegionIso(): string
    {
        return $this->regionIso;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getRecap(): ?string
    {
        return $this->recap;
    }

    public function getReference(): string
    {
        return $this->reference;
    }
}
