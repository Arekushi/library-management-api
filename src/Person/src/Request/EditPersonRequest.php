<?php

namespace Person\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;
use Person\Model\Telephone;

#[OAT\Schema(schema: 'EditPersonRequest')]
class EditPersonRequest
{
    #[Assert\Length(min: 3, minMessage: "The name must be at least 3 characters long.")]
    #[OAT\Property(type: 'string')]
    public ?string $name = null;

    #[Assert\Email(message: "The email '{{ value }}' is not a valid email address.")]
    #[OAT\Property(type: 'string')]
    public ?string $email = null;

    #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/EditTelephoneRequest'))]
    public ?array $telephones = [];

    public function getTelephones()
    {
        return $this->telephones;
    }

    public function setTelephones(array $telephones)
    {
        $this->telephones = $telephones;
    }
}
