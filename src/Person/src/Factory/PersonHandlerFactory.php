<?php

declare(strict_types=1);

namespace Person\Factory;

use Person\Handler\PersonHandler;
use Person\Service\PersonService;
use Psr\Container\ContainerInterface;

class PersonHandlerFactory
{
    public function __invoke(ContainerInterface $container): PersonHandler
    {
        $personService = $container->get(PersonService::class);
        return new PersonHandler($personService);
    }
}
