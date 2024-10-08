<?php

namespace Library\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'CreateLoanRequest')]
class CreateLoanRequest
{
    #[Assert\NotBlank(message: "The person ID cannot be empty.")]
    #[OAT\Property(type: 'string')]
    public string $personId;

    #[Assert\NotBlank(message: "The book ID cannot be empty.")]
    #[OAT\Property(type: 'string')]
    public string $bookId;

    #[Assert\NotBlank(message: "The loan end date cannot be empty.")]
    #[Assert\DateTime(message: "The loan end date must be a valid date and time.")]
    #[OAT\Property(type: 'string', format: 'date-time')]
    public string $loanEndDate;
}
