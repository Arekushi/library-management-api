<?php

namespace Library\Factory;

use AutoMapperPlus\AutoMapper;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use Library\Model\Book;
use Library\Repository\BookRepository;
use Library\Service\BookService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class BookServiceFactory
{
    public function __invoke(ContainerInterface $container): BookService
    {
        /** @var ORM $orm */
        $orm = $container->get('orm');

        $mapper = $container->get(AutoMapper::class);

        /** @var BookRepository $bookRepository */
        $bookRepository = $orm->getRepository(Book::class);

        $bookRepository->setEntityManager(new EntityManager($orm));
        $bookRepository->setEntityClass(Book::class);
        $bookRepository->logger = $container->get(LoggerInterface::class);

        $bookService = new BookService($bookRepository);
        $bookService->setMapper($mapper);

        return $bookService;
    }
}
