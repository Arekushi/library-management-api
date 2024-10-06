<?php

namespace Person\Factory;

use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Person\Model\Person;
use Person\Repository\PersonRepository;
use Person\Service\PersonService;
use Psr\Container\ContainerInterface;

class PersonServiceFactory
{
    public function __invoke(ContainerInterface $container): PersonService
    {
        $orm = $container->get(ORM::class);

        /** @var PersonRepository $personRepository */
        $personRepository = $orm->getRepository(Person::class);
        $entityManager = new EntityManager($orm);
        $personRepository->setEntityManager($entityManager);

        return new PersonService($personRepository);
    }
}
