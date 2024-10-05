<?php

declare(strict_types=1);

namespace People;

use People\Factory\PeopleHandlerFactory;
use People\Factory\PeopleServiceFactory;
use People\Handler\PeopleHandler;
use People\Service\PeopleService;

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
                PeopleService::class => PeopleServiceFactory::class,
                PeopleHandler::class => PeopleHandlerFactory::class,
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'name' => 'people.get',
                'path' => '/people/{id}',
                'middleware' => PeopleHandler::class,
                'allowed_methods' => ['GET'],
            ]
        ];
    }
}
