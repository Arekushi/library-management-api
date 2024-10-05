<?php

declare(strict_types=1);

namespace People\Factory;

use People\Handler\PeopleHandler;
use People\Service\PeopleService;
use Psr\Container\ContainerInterface;

class PeopleHandlerFactory
{
    public function __invoke(ContainerInterface $container): PeopleHandler
    {
        $peopleService = $container->get(PeopleService::class);
        return new PeopleHandler($peopleService);
    }
}
