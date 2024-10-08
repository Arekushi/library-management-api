<?php

namespace Library\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'GetBookResponse')]
class GetBookResponse
{
    #[OAT\Property(type: 'string')]
    public string $uuid;

    #[OAT\Property(type: 'string')]
    public string $title;

    #[OAT\Property(type: 'string')]
    public string $isbn;

    #[OAT\Property(type: 'string')]
    public ?string $description;

    #[OAT\Property(type: 'string')]
    public ?string $publisher;

    #[OAT\Property(type: 'int')]
    public int $copies;

    #[OAT\Property(type: 'int')]
    public int $publicationYear;
}
