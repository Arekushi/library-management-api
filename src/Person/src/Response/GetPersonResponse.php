<?php

namespace Person\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'GetPersonResponse')]
class GetPersonResponse
{
    #[OAT\Property(type: 'string')]
    public string $uuid;

    #[OAT\Property(type: 'string')]
    public string $name;

    #[OAT\Property(type: 'string')]
    public string $email;
}
