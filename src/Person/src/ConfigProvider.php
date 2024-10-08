<?php

declare(strict_types=1);

namespace Person;

use Person\Factory\PersonHandlerFactory;
use Person\Factory\PersonServiceFactory;
use Person\Handler\PersonHandler;
use Person\Service\PersonService;

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
                PersonService::class => PersonServiceFactory::class,
                PersonHandler::class => PersonHandlerFactory::class
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'name' => 'person.get',
                'path' => '/person/{id}',
                'middleware' => PersonHandler::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name' => 'person.list',
                'path' => '/person',
                'middleware' => PersonHandler::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name' => 'person.create',
                'path' => '/person',
                'middleware' => PersonHandler::class,
                'allowed_methods' => ['POST']
            ],
            [
                'name' => 'person.delete',
                'path' => '/person/{id}',
                'middleware' => PersonHandler::class,
                'allowed_methods' => ['DELETE']
            ],
            [
                'name' => 'person.patch',
                'path' => '/person/{id}',
                'middleware' => PersonHandler::class,
                'allowed_methods' => ['PATCH']
            ],
            [
                'name' => 'person.put',
                'path' => '/person/{id}',
                'middleware' => PersonHandler::class,
                'allowed_methods' => ['PUT']
            ]
        ];
    }
}
