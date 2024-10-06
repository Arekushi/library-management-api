<?php

namespace Person\Factory;

use Cycle\ORM\ORM;
use Person\Model\Person;
use Person\Repository\PersonRepository;
use Psr\Container\ContainerInterface;
use Person\Service\PersonService;

class PersonServiceFactory
{
    public function __invoke(ContainerInterface $container): PersonService
    {
        $orm = $container->get(ORM::class);
        $userRepository = $orm->getRepository(Person::class);
        return new PersonService($userRepository);
    }
}
