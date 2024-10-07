<?php

namespace App\Factory;

use App\Middleware\ExceptionHandlerMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class ExceptionHandlerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): ExceptionHandlerMiddleware
    {
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        return new ExceptionHandlerMiddleware($responseFactory);
    }
}
