<?php

namespace App\Response;

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'DeletedSuccessfullyResponse')]
class DeletedSuccessfullyResponse
{
    #[OAT\Property(type: 'string')]
    public string $message;

    public function __construct(
        string $message = 'Deleted successfully'
    )
    {
        $this->message = $message;
    }
}
