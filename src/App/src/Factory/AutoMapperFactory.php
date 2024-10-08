<?php

namespace App\Factory;

use App\Class\Route;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\MappingOperation\Operation;
use Person\Model\Person;
use Person\Model\Telephone;
use Person\Request\CreatePersonRequest;
use Person\Response\GetPersonResponse;
use Psr\Container\ContainerInterface;
use AutoMapperPlus\AutoMapper;
use Library\Model\Book;
use Library\Model\Loan;
use Library\Request\CreateBookRequest;
use Library\Request\CreateLoanRequest;
use Library\Request\EditBookRequest;
use Library\Request\ReturnBookRequest;
use Library\Response\GetBookResponse;
use Library\Response\GetLoanResponse;
use Person\Request\EditPersonRequest;
use Person\Response\GetTelephoneResponse;

class AutoMapperFactory
{
    public function __invoke(ContainerInterface $container): AutoMapper
    {
        $config = new AutoMapperConfig();

        /** Array to Route */
        $config->registerMapping('array', Route::class)
            ->forMember('callback', fn(array $source) => $source['callback'])
            ->forMember('requestClass', fn(array $source) => $source['requestClass'] ?? null)
            ->forMember('responseClass', fn(array $source) => $source['responseClass'] ?? null)
            ->forMember('responseStatus', fn(array $source) => $source['responseStatus'] ?? 200);

        /** Person to PersonResponse */
        $config->registerMapping(Telephone::class, GetTelephoneResponse::class)
            ->forMember('number', fn(Telephone $source) => $source->getNumber());

        $config->registerMapping(Person::class, GetPersonResponse::class)
            ->forMember('telephones', function (Person $source, $destination, $context) use ($config) {
                $autoMapper = new AutoMapper($config);
                return $autoMapper->mapMultiple($source->getTelephones(), GetTelephoneResponse::class);
            })
            ->reverseMap();

        /** Person Request to Person */
        $config->registerMapping('array', CreatePersonRequest::class);
        $config->registerMapping('array', EditPersonRequest::class);

        $config->registerMapping(CreatePersonRequest::class, Person::class)
            ->forMember('telephones', function (CreatePersonRequest $source, $destination, $context) use ($config) {
                $autoMapper = new AutoMapper($config);
                return $autoMapper->mapMultiple($source->getTelephones(), Telephone::class);
            });

        $config->registerMapping(EditPersonRequest::class, Person::class)
            ->forMember('telephones', function (EditPersonRequest $source, $destination, $context) use ($config) {
                $autoMapper = new AutoMapper($config);
                return $autoMapper->mapMultiple($source->getTelephones(), Telephone::class);
            });

        $config->registerMapping('array', Telephone::class)
            ->forMember('number', fn($source) => $source['number']);

        /** Book Request to Book */
        $config->registerMapping('array', CreateBookRequest::class);
        $config->registerMapping('array', EditBookRequest::class);

        $config->registerMapping(CreateBookRequest::class, Book::class);
        $config->registerMapping(EditBookRequest::class, Book::class);

        /** Book to Book Response */
        $config->registerMapping(Book::class, GetBookResponse::class);

        /** Loan Request */
        $config->registerMapping('array', CreateLoanRequest::class);
        $config->registerMapping('array', ReturnBookRequest::class);

        /** Loan to Loan Response */
        $config->registerMapping(Loan::class, GetLoanResponse::class)
            ->forMember('person', function (Loan $source, AutoMapper $mapper) {
                return $mapper->map($source->getPerson(), GetPersonResponse::class);
            })
            ->forMember('book', function (Loan $source, AutoMapper $mapper) {
                return $mapper->map($source->getBook(), GetBookResponse::class);
            });

        $mapper = new AutoMapper($config);
        return $mapper;
    }
}
