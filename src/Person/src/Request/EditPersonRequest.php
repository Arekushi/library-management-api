<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'EditPersonRequest')]
class EditPersonRequest
{
    #[Assert\Length(min: 3, minMessage: "O nome deve ter pelo menos 3 caracteres")]
    #[OAT\Property(type: 'string')]
    public ?string $name = null;

    #[Assert\Email(message: "O email '{{ value }}' não é um email válido")]
    #[OAT\Property(type: 'string')]
    public ?string $email = null;
}
