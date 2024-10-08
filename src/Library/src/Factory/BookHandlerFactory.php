<?php

declare(strict_types=1);

namespace Library\Factory;

use AutoMapperPlus\AutoMapper;
use Library\Handler\BookHandler;
use Library\Service\BookService;
use Psr\Container\ContainerInterface;

class BookHandlerFactory
{
    public function __invoke(ContainerInterface $container): BookHandler
    {
        $bookService = $container->get(BookService::class);
        $mapper = $container->get(AutoMapper::class);
        $handler = new BookHandler($bookService);
        $handler->setMapper($mapper);

        return $handler;
    }
}
