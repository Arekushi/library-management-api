<?php

namespace Person\Factory;

use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Person\Model\Person;
use Person\Repository\PersonRepository;
use Person\Service\PersonService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class PersonServiceFactory
{
    public function __invoke(ContainerInterface $container): PersonService
    {
        /** @var ORM $orm */
        $orm = $container->get('orm');

        /** @var PersonRepository $personRepository */
        $personRepository = $orm->getRepository(Person::class);

        $personRepository->setEntityManager(new EntityManager($orm));
        $personRepository->setEntityClass(Person::class);
        $personRepository->logger = $container->get(LoggerInterface::class);

        return new PersonService($personRepository);
    }
}
