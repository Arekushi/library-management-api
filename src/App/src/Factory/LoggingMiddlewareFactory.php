<?php

declare(strict_types=1);

namespace App\Factory;

use App\Middleware\LoggingMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoggingMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): LoggingMiddleware
    {
        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);
        $middleware = new LoggingMiddleware($logger);

        return $middleware;
    }
}
