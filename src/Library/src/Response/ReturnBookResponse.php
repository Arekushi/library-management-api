<?php

namespace Library\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'ReturnBookResponse')]
class ReturnBookResponse
{
    #[OAT\Property(type: 'bool')]
    public bool $isOnDeadline;

    #[OAT\Property(type: 'string')]
    public string $message;

    public function __construct(bool $isOnDeadline) {
        $this->isOnDeadline = $isOnDeadline;
        $this->message = $isOnDeadline ?
            'Thank you for returning within the stipulated time'
            : 'You returned the book after the stipulated deadline, try to return it on time next time';
    }
}
