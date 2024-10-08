<?php

declare(strict_types=1);

namespace Person\Handler;

use App\Abstract\BaseHandler;
use Person\Model\Person;
use Person\Request\CreatePersonRequest;
use Person\Request\EditPersonRequest;
use Person\Response\GetPersonResponse;
use Person\Service\PersonService;
use Person\Swagger\PersonHandlerSwagger;

class PersonHandler extends BaseHandler implements PersonHandlerSwagger
{
    public function __construct(PersonService $personService)
    {
        $this->service = $personService;
        $this->routes = [
            'person.get' => [
                'callback' => [$this, 'get'],
                'responseClass' => GetPersonResponse::class
            ],
            'person.list' => [
                'callback' => [$this, 'list'],
                'responseClass' => GetPersonResponse::class
            ],
            'person.create' => [
                'callback' => [$this, 'create'],
                'responseStatus' => 201,
                'requestClass' => CreatePersonRequest::class,
                'responseClass' => GetPersonResponse::class
            ],
            'person.delete' => [
                'callback' => [$this, 'delete']
            ],
            'person.edit' => [
                'callback' => [$this, 'edit'],
                'requestClass' => EditPersonRequest::class,
                'responseClass' => GetPersonResponse::class
            ]
        ];
    }
}
