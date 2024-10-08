<?php

declare(strict_types=1);

namespace Person\Handler;

use App\Abstract\BasicHandler;
use Person\Request\CreatePersonRequest;
use Person\Request\EditPersonRequest;
use Person\Response\GetPersonResponse;
use Person\Service\PersonService;
use Psr\Http\Message\ServerRequestInterface;

use OpenApi\Attributes as OAT;

class PersonHandler extends BasicHandler
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

    #[OAT\Get(
        path: '/person/{id}',
        operationId: 'getPersonById',
        summary: 'Get person details by id',
        tags: ['Person'],
        parameters: [
            new OAT\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string')
            )
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Person',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetPersonResponse'),
            ),
        ]
    )]
    public function get(ServerRequestInterface $request)
    {
        return parent::get($request);
    }

    public function list(ServerRequestInterface $request)
    {
        return parent::list($request);
    }

    public function create(ServerRequestInterface $request)
    {
        return parent::create($request);
    }

    public function delete(ServerRequestInterface $request)
    {
        return parent::delete($request);
    }

    public function edit(ServerRequestInterface $request)
    {
        return parent::edit($request);
    }
}
