<?php

namespace Person\Swagger;

use App\Class\Route;
use Psr\Http\Message\ServerRequestInterface;
use OpenApi\Attributes as OAT;

interface PersonHandlerSwagger
{
    #[OAT\Get(
        path: '/person/{id}',
        operationId: 'getPersonById',
        summary: 'Retrieve the details of a specific person by their unique identifier',
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
                description: 'Successful retrieval of the person object',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetPersonResponse'),
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified person could not be found',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function get(Route $route, ServerRequestInterface $request);

    #[OAT\Get(
        path: '/person',
        operationId: 'listPersons',
        summary: 'Fetch a comprehensive list of all registered persons',
        tags: ['Person'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully retrieved the list of persons',
                content: new OAT\JsonContent(type: 'array', items: new OAT\Items(ref: '#/components/schemas/GetPersonResponse'))
            )
        ]
    )]
    public function list(Route $route, ServerRequestInterface $request);

    #[OAT\Post(
        path: '/person',
        operationId: 'createPerson',
        summary: 'Create a new person record with the provided details',
        tags: ['Person'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/CreatePersonRequest')
        ),
        responses: [
            new OAT\Response(
                response: 201,
                description: 'Successfully created a new person record',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetPersonResponse')
            ),
            new OAT\Response(
                response: 400,
                description: 'Invalid request payload; please check the JSON body format',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function create(Route $route, ServerRequestInterface $request);

    #[OAT\Delete(
        path: '/person/{id}',
        operationId: 'deletePerson',
        summary: 'Remove a person record identified by their unique identifier',
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
                description: 'The person record was successfully deleted',
                content: new OAT\JsonContent(ref: '#/components/schemas/DeletedSuccessfullyResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified person could not be found for deletion',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function delete(Route $route, ServerRequestInterface $request);

    #[OAT\Put(
        path: '/person/{id}',
        operationId: 'putPerson',
        summary: 'Update the details of an existing person record identified by their unique identifier',
        tags: ['Person'],
        parameters: [
            new OAT\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string')
            )
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/CreatePersonRequest')
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully updated the person record',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetPersonResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified person could not be found for update'
            ),
            new OAT\Response(
                response: 400,
                description: 'Invalid request payload; please check the JSON body format',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function put(Route $route, ServerRequestInterface $request);

    #[OAT\Patch(
        path: '/person/{id}',
        operationId: 'patchPerson',
        summary: 'Update the details of an existing person record identified by their unique identifier',
        tags: ['Person'],
        parameters: [
            new OAT\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'string')
            )
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/EditPersonRequest')
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully updated the person record',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetPersonResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified person could not be found for update'
            ),
            new OAT\Response(
                response: 400,
                description: 'Invalid request payload; please check the JSON body format',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function patch(Route $route, ServerRequestInterface $request);
}
