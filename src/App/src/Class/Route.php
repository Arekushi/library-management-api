<?php

namespace App\Class;

class Route
{
    private $callback;

    private ?string $requestClass;

    private ?string $responseClass;

    private ?int $responseStatus;

    public function getCallback() {
        return $this->callback;
    }

    public function setCallback($callback) {
        $this->callback = $callback;
    }

    public function getRequestClass(): ?string {
        return $this->requestClass;
    }

    public function setRequestClass(?string $requestClass) {
        $this->requestClass = $requestClass;
    }

    public function getResponseClass(): ?string {
        return $this->responseClass;
    }

    public function setResponseClass(?string $responseClass) {
        $this->responseClass = $responseClass;
    }

    public function getResponseStatus(): ?int {
        return $this->responseStatus;
    }

    public function setResponseStatus(?int $responseStatus = 200) {
        $this->responseStatus = $responseStatus;
    }
}
