<?php

namespace Person\Response;

use App\Attribute\RelatedCollection;
use OpenApi\Attributes as OAT;
use Person\Model\Telephone;

#[OAT\Schema(schema: 'GetPersonResponse')]
class GetPersonResponse
{
    #[OAT\Property(type: 'string')]
    public string $uuid;

    #[OAT\Property(type: 'string')]
    public string $name;

    #[OAT\Property(type: 'string')]
    public string $email;

    #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/GetTelephoneResponse'))]
    #[RelatedCollection(
        GetTelephoneResponse::class,
        'getTelephones',
        'setTelephones'
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
