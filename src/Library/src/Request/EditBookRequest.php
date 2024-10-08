<?php

namespace Library\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'EditBookRequest')]
class EditBookRequest
{
    #[Assert\Length(min: 3, minMessage: "The title must be at least 3 characters long.")]
    #[OAT\Property(type: 'string')]
    public ?string $title = null;

    #[OAT\Property(type: 'string')]
    public ?string $isbn = null;

    #[OAT\Property(type: 'string')]
    public ?string $description = null;

    #[OAT\Property(type: 'string')]
    public ?string $publisher = null;

    #[Assert\Type('integer')]
    #[Assert\GreaterThanOrEqual(0, message: "The number of copies must be greater than or equal to 0.")]
    #[OAT\Property(type: 'int')]
    public ?int $copies = null;

    #[Assert\Type('integer')]
    #[Assert\Range(
        min: 1500,
        max: 2100,
        notInRangeMessage: 'The publication year must be between {{ min }} and {{ max }}.'
    )]
    #[OAT\Property(type: 'int')]
    public ?int $publicationYear = null;
}
