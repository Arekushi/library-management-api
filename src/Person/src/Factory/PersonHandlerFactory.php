<?php

declare(strict_types=1);

namespace Person\Factory;

use AutoMapperPlus\AutoMapper;
use Person\Handler\PersonHandler;
use Person\Service\PersonService;
use Psr\Container\ContainerInterface;

class PersonHandlerFactory
{
    public function __invoke(ContainerInterface $container): PersonHandler
    {
        $personService = $container->get(PersonService::class);
        $mapper = $container->get(AutoMapper::class);

        $handler = new PersonHandler($personService);
        $handler->setMapper($mapper);
        return $handler;
    }
}
