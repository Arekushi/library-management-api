<?php

namespace Person\Factory;

use AutoMapperPlus\AutoMapper;
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

        $mapper = $container->get(AutoMapper::class);

        /** @var PersonRepository $personRepository */
        $personRepository = $orm->getRepository(Person::class);

        $personRepository->setEntityManager(new EntityManager($orm));
        $personRepository->setEntityClass(Person::class);
        $personRepository->logger = $container->get(LoggerInterface::class);

        $personService = new PersonService($personRepository);
        $personService->setMapper($mapper);

        return $personService;
    }
}
