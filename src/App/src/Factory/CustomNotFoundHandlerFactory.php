<?php

namespace App\Factory;

use App\Handler\CustomNotFoundHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class CustomNotFoundHandlerFactory
{
    public function __invoke(ContainerInterface $container): CustomNotFoundHandler
    {
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        return new CustomNotFoundHandler($responseFactory);
    }
}
