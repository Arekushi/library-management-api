<?php

declare(strict_types=1);

namespace Library;

use Library\Factory\BookHandlerFactory;
use Library\Factory\BookServiceFactory;
use Library\Handler\BookHandler;
use Library\Service\BookService;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRoutes(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                BookService::class => BookServiceFactory::class,
                BookHandler::class => BookHandlerFactory::class
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'name' => 'book.get',
                'path' => '/book/{id}',
                'middleware' => BookHandler::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name' => 'book.list',
                'path' => '/book',
                'middleware' => BookHandler::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name' => 'book.create',
                'path' => '/book',
                'middleware' => BookHandler::class,
                'allowed_methods' => ['POST']
            ],
            [
                'name' => 'book.delete',
                'path' => '/book/{id}',
                'middleware' => BookHandler::class,
                'allowed_methods' => ['DELETE']
            ],
            [
                'name' => 'book.patch',
                'path' => '/book/{id}',
                'middleware' => BookHandler::class,
                'allowed_methods' => ['PATCH']
            ],
            [
                'name' => 'book.put',
                'path' => '/book/{id}',
                'middleware' => BookHandler::class,
                'allowed_methods' => ['PUT']
            ]
        ];
    }
}
