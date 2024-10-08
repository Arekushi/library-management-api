<?php

declare(strict_types=1);

namespace Library\Factory;

use AutoMapperPlus\AutoMapper;
use Library\Handler\LoanHandler;
use Library\Service\LoanService;
use Psr\Container\ContainerInterface;

class LoanHandlerFactory
{
    public function __invoke(ContainerInterface $container): LoanHandler
    {
        $bookService = $container->get(LoanService::class);
        $mapper = $container->get(AutoMapper::class);
        $handler = new LoanHandler($bookService);
        $handler->setMapper($mapper);

        return $handler;
    }
}
