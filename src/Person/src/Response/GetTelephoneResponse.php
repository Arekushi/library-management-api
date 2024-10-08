<?php

namespace Person\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'GetTelephoneResponse')]
class GetTelephoneResponse
{
    #[OAT\Property(type: 'string')]
    public string $number;
}
