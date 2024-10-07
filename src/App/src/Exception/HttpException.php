<?php

namespace App\Exception;

use Exception;

class HttpException extends Exception
{
    private int $statusCode;

    private object|array $error;

    public function __construct(
        string $message,
        int $statusCode,
        object|array $error = null,
        ?Exception $previous = null
    )
    {
        parent::__construct($message, 0, $previous);
        $this->statusCode = $statusCode;
        $this->error = $error;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getError()
    {
        return $this->error;
    }
}
