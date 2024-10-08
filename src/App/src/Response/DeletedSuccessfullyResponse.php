<?php

namespace App\Response;

class DeletedSuccessfullyResponse
{
    public string $message;

    public  function __construct(string $message = 'Deleted successfully')
    {
        $this->message = $message;
    }
}
