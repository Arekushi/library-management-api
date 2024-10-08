<?php

declare(strict_types=1);

namespace Library;

use Library\Factory\BookHandlerFactory;
use Library\Factory\BookServiceFactory;
use Library\Factory\LoanHandlerFactory;
use Library\Factory\LoanServiceFactory;
use Library\Handler\BookHandler;
use Library\Handler\LoanHandler;
use Library\Service\BookService;
use Library\Service\LoanService;

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
                BookHandler::class => BookHandlerFactory::class,
                LoanService::class => LoanServiceFactory::class,
                LoanHandler::class => LoanHandlerFactory::class
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
            ],
            [
                'name' => 'loan.get',
                'path' => '/loan/{id}',
                'middleware' => LoanHandler::class,
                'allowed_methods' => ['GET']
            ],
            [
                'name' => 'loan.list',
                'path' => '/loan',
                'middleware' => LoanHandler::class,
                'allowed_methods' => ['GET']
            ],
            [
                'name' => 'loan.create',
                'path' => '/loan/create',
                'middleware' => LoanHandler::class,
                'allowed_methods' => ['POST']
            ],
            [
                'name' => 'loan.return',
                'path' => '/loan/return',
                'middleware' => LoanHandler::class,
                'allowed_methods' => ['POST']
            ],
        ];
    }
}
