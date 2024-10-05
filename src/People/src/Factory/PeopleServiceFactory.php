<?php

namespace People\Factory;

use Cycle\ORM\ORM;
use People\Model\People;
use People\Repository\PeopleRepository;
use Psr\Container\ContainerInterface;
use People\Service\PeopleService;

class PeopleServiceFactory
{
    public function __invoke(ContainerInterface $container): PeopleService
    {
        $orm = $container->get(ORM::class);
        $userRepository = $orm->getRepository(People::class);
        return new PeopleService($userRepository);
    }
}
