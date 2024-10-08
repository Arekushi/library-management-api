<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;

class EditPersonRequest
{
    #[Assert\Length(min: 3, minMessage: "O nome deve ter pelo menos 3 caracteres")]
    public ?string $name = null;

    #[Assert\Email(message: "O email '{{ value }}' não é um email válido")]
    public ?string $email = null;
}
