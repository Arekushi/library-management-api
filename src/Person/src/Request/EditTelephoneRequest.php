<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'EditTelephoneRequest')]
class EditTelephoneRequest
{
    #[Assert\Length(min: 3, minMessage: "The telephone number must be at least 3 characters long.")]
    #[OAT\Property(type: 'string')]
    public ?string $number = null;
}
