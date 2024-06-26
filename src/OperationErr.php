<?php

namespace sshgun\PayphonePHP;

use Exception;

/**
 * @author sshgun
 */
class OperationErr
{
    private int $_code;
    private string $_error;
    private ?Exception $_e;

    public function __construct(string $error, int $code = 0, ?Exception $e = null)
    {
        $this->_code = $code;
        $this->_error = $error;
        $this->_e = $e;
    }

    public function getCode(): int
    {
        return $this->_code;
    }

    public function getError(): string
    {
        return $this->_error;
    }

    public function getException(): ?Exception
    {
        return $this->_e;
    }
}
