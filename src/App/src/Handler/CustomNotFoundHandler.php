<?php

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class CustomNotFoundHandler implements RequestHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse(404);

        $errorMessage = json_encode([
            'error' => 'Route not found',
            'message' => 'The requested route does not exist on the server.',
            'path' => $request->getUri()->getPath(),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $response->getBody()->write($errorMessage);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
