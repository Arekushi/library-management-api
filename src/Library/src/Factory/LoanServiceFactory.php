<?php

namespace Library\Factory;

use AutoMapperPlus\AutoMapper;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Library\Model\Book;
use Library\Model\Loan;
use Library\Repository\BookRepository;
use Library\Repository\LoanRepository;
use Library\Service\LoanService;
use Person\Model\Person;
use Person\Repository\PersonRepository;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoanServiceFactory
{
    public function __invoke(ContainerInterface $container): LoanService
    {
        /** @var ORM $orm */
        $orm = $container->get('orm');

        $mapper = $container->get(AutoMapper::class);

        /** @var LoanRepository $loanRepository */
        $loanRepository = $orm->getRepository(Loan::class);
        $loanRepository->setEntityManager(new EntityManager($orm));
        $loanRepository->setEntityClass(Loan::class);
        $loanRepository->logger = $container->get(LoggerInterface::class);

        /** @var BookRepository $bookRepository */
        $bookRepository = $orm->getRepository(Book::class);
        $bookRepository->setEntityManager(new EntityManager($orm));
        $bookRepository->setEntityClass(Book::class);
        $bookRepository->logger = $container->get(LoggerInterface::class);

        /** @var PersonRepository $personRepository */
        $personRepository = $orm->getRepository(Person::class);
        $personRepository->setEntityManager(new EntityManager($orm));
        $personRepository->setEntityClass(Person::class);
        $personRepository->logger = $container->get(LoggerInterface::class);

        $loanService = new LoanService($loanRepository, $bookRepository, $personRepository);
        $loanService->setMapper($mapper);

        return $loanService;
    }
}
