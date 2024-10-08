<?php

namespace Person\Request;

use App\Attribute\RelatedCollection;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;
use Person\Model\Telephone;

#[OAT\Schema(schema: 'EditPersonRequest')]
class EditPersonRequest
{
    #[Assert\Length(min: 3, minMessage: "O nome deve ter pelo menos 3 caracteres")]
    #[OAT\Property(type: 'string')]
    public ?string $name = null;

    #[Assert\Email(message: "O email '{{ value }}' não é um email válido")]
    #[OAT\Property(type: 'string')]
    public ?string $email = null;

    #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/EditTelephoneRequest'))]
    #[RelatedCollection(
        Telephone::class
    )]
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
