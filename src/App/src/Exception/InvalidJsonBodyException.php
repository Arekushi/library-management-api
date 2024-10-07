<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidJsonBodyException extends HttpException
{
    public function __construct(
        ConstraintViolationListInterface $violations,
        string $message = 'Invalid JSON body',
        int $statusCode = 400,
        ?Exception $previous = null
    )
    {
        $errors = [];

        foreach ($violations as $violation)
        {
            $errors[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        parent::__construct(
            $message,
            $statusCode,
            $errors,
            $previous
        );
    }
}
