<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'CreateTelephoneRequest')]
class CreateTelephoneRequest
{
    #[Assert\NotBlank(message: "O telephone não pode estar vazio")]
    #[Assert\Length(min: 3, minMessage: "O telephone deve ter pelo menos 3 caracteres")]
    #[OAT\Property(type: 'string')]
    public string $number;
}
