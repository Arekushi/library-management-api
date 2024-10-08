<?php

namespace App\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'ExceptionResponse')]
class ExceptionResponse
{
    #[OAT\Property(type: 'string')]
    public string $message;

    #[OAT\Property(type: 'int')]
    public int $statusCode;

    #[OAT\Property(anyOf: [
        new OAT\Schema(type: 'object'),
        new OAT\Schema(type: 'array'),
        new OAT\Schema(type: 'null'),
    ])]
    public object|array|null $error;

    public function __construct(
        string $message,
        int $statusCode,
        object|array|null $error = null
    )
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->error = $error;
    }
}
