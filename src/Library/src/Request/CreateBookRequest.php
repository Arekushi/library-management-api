<?php

namespace Library\Request;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'CreateBookRequest')]
class CreateBookRequest
{
    #[Assert\NotBlank(message: "The title cannot be empty.")]
    #[Assert\Length(min: 3, minMessage: "The title must be at least 3 characters long.")]
    #[OAT\Property(type: 'string')]
    public string $title;

    #[Assert\NotBlank(message: "The ISBN cannot be empty.")]
    #[OAT\Property(type: 'string')]
    public string $isbn;

    #[OAT\Property(type: 'string')]
    public ?string $description;

    #[OAT\Property(type: 'string')]
    public ?string $publisher;

    #[Assert\NotBlank(message: "The number of copies cannot be empty.")]
    #[Assert\Type('integer')]
    #[Assert\GreaterThanOrEqual(0, message: "The number of copies must be greater than or equal to 0.")]
    #[OAT\Property(type: 'int')]
    public int $copies;

    #[Assert\NotBlank(message: "The publication year cannot be empty.")]
    #[Assert\Type('integer')]
    #[Assert\Range(
        min: 1500,
        max: 2100,
        notInRangeMessage: 'The publication year must be between {{ min }} and {{ max }}.'
    )]
    #[OAT\Property(type: 'int')]
    public int $publicationYear;
}
