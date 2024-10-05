<?php

declare(strict_types=1);

namespace App\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container): Logger
    {
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler('./log/app.log', Logger::DEBUG));
        return $logger;
    }
}
