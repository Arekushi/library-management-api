<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use App\Exception\HttpException;
use Throwable;

class ExceptionHandlerMiddleware implements MiddlewareInterface
{
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (HttpException $e) {
            return $this->handleHttpException($e);
        } catch (Throwable $e) {
            return $this->handleGenericException($e);
        }
    }

    private function handleHttpException(HttpException $e): ResponseInterface
    {
        $statusCode = $e->getStatusCode();
        $response = $this->responseFactory->createResponse($statusCode);

        $jsonData = [
            'message' => $e->getMessage(),
            'code' => $statusCode,
        ];

        $error = $e->getError();
        if ($error !== null) {
            $jsonData['error'] = $error;
        }

        $response->getBody()->write(json_encode($jsonData));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function handleGenericException(Throwable $e): ResponseInterface
    {
        $response = $this->responseFactory->createResponse(500);
        $response->getBody()->write(json_encode([
            'error' => 'Internal Server Error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
