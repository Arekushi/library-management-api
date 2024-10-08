<?php

namespace Library\Swagger;

use App\Class\Route;
use Psr\Http\Message\ServerRequestInterface;
use OpenApi\Attributes as OAT;

interface BookHandlerSwagger
{
    #[OAT\Get(
        path: '/book/{id}',
        operationId: 'getBookById',
        summary: 'Retrieve the details of a specific book by its unique identifier',
        tags: ['Book'],
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
                description: 'Successful retrieval of the book object',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetBookResponse'),
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified book could not be found',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function get(Route $route, ServerRequestInterface $request);

    #[OAT\Get(
        path: '/book',
        operationId: 'listBooks',
        summary: 'Fetch a comprehensive list of all registered books',
        tags: ['Book'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully retrieved the list of books',
                content: new OAT\JsonContent(type: 'array', items: new OAT\Items(ref: '#/components/schemas/GetBookResponse'))
            )
        ]
    )]
    public function list(Route $route, ServerRequestInterface $request);

    #[OAT\Post(
        path: '/book',
        operationId: 'createBook',
        summary: 'Create a new book record with the provided details',
        tags: ['Book'],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/CreateBookRequest')
        ),
        responses: [
            new OAT\Response(
                response: 201,
                description: 'Successfully created a new book record',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetBookResponse')
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
        path: '/book/{id}',
        operationId: 'deleteBook',
        summary: 'Remove a book record identified by its unique identifier',
        tags: ['Book'],
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
                description: 'The book record was successfully deleted',
                content: new OAT\JsonContent(ref: '#/components/schemas/DeletedSuccessfullyResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified book could not be found for deletion',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function delete(Route $route, ServerRequestInterface $request);

    #[OAT\Put(
        path: '/book/{id}',
        operationId: 'putBook',
        summary: 'Update the details of an existing book record identified by its unique identifier',
        tags: ['Book'],
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
            content: new OAT\JsonContent(ref: '#/components/schemas/CreateBookRequest')
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully updated the book record',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetBookResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified book could not be found for update'
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
        path: '/book/{id}',
        operationId: 'patchBook',
        summary: 'Update the details of an existing book record identified by its unique identifier',
        tags: ['Book'],
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
            content: new OAT\JsonContent(ref: '#/components/schemas/EditBookRequest')
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully updated the book record',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetBookResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified book could not be found for update'
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
