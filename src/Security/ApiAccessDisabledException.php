<?php

namespace App\Security;

class ApiAccessDisabledException extends \Exception
{
    private string $apiMessage;

    public function __construct(string $message = 'API access is not enabled.', ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->apiMessage = $message;
    }

    public function getApiMessage(): string
    {
        return $this->apiMessage;
    }
}
