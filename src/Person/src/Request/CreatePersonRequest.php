<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreatePersonRequest
{
    #[Assert\NotBlank(message: "O nome não pode estar vazio")]
    #[Assert\Length(min: 3, minMessage: "O nome deve ter pelo menos 3 caracteres")]
    public string $name;

    #[Assert\NotBlank(message: "O email não pode estar vazio")]
    #[Assert\Email(message: "O email '{{ value }}' não é um email válido")]
    public string $email;
}
