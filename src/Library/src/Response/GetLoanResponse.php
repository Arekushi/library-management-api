<?php

namespace Library\Response;

use Library\Model\Book;
use OpenApi\Attributes as OAT;
use Library\Response\GetBookResponse;
use Person\Model\Person;
use Person\Response\GetPersonResponse;

#[OAT\Schema(schema: 'GetLoanResponse')]
class GetLoanResponse
{
    #[OAT\Property(type: 'string')]
    public string $uuid;

    #[OAT\Property(ref: '#/components/schemas/GetPersonResponse')]
    public GetPersonResponse $person;

    #[OAT\Property(ref: '#/components/schemas/GetBookResponse')]
    public GetBookResponse $book;

    #[OAT\Property(type: 'string', format: 'date-time')]
    public \DateTimeImmutable $loanStartDate;

    #[OAT\Property(type: 'string', format: 'date-time')]
    public \DateTimeImmutable $loanEndDate;
}
