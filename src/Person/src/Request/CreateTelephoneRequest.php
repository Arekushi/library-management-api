<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'CreateTelephoneRequest')]
class CreateTelephoneRequest
{
    #[Assert\NotBlank(message: "The telephone number cannot be empty.")]
    #[Assert\Length(min: 3, minMessage: "The telephone number must be at least 3 characters long.")]
    #[OAT\Property(type: 'string')]
    public string $number;
}
