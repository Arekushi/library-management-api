<?php

namespace Library\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'ReturnBookRequest')]
class ReturnBookRequest
{
    #[Assert\NotBlank(message: "The person ID cannot be empty.")]
    #[OAT\Property(type: 'string')]
    public string $personId;

    #[Assert\NotBlank(message: "The book ID cannot be empty.")]
    #[OAT\Property(type: 'string')]
    public string $bookId;
}
