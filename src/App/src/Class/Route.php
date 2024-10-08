<?php

namespace App\Class;

class Route
{
    private $callback;

    private ?string $requestClass;

    private ?string $responseClass;

    private ?int $responseStatus;

    public function __construct(
        $callback,
        ?string $requestClass = null,
        ?string $responseClass = null,
        ?int $responseStatus = 200
    )
    {
        $this->callback = $callback;
        $this->requestClass = $requestClass;
        $this->responseClass = $responseClass;
        $this->responseStatus = $responseStatus;
    }

    public function getResponseStatus(): ?int {
        return $this->responseStatus;
    }

    public function getResponseClass(): ?string {
        return $this->responseClass;
    }

    public function getRequestClass(): ?string {
        return $this->requestClass;
    }

    public function getCallback() {
        return $this->callback;
    }
}
