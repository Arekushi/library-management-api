<?php

namespace Library\Swagger;

use App\Class\Route;
use Psr\Http\Message\ServerRequestInterface;
use OpenApi\Attributes as OAT;

interface LoanHandlerSwagger
{
    #[OAT\Get(
        path: '/loan/{id}',
        operationId: 'getLoanById',
        summary: 'Retrieve the details of a specific loan by its unique identifier',
        tags: ['Loan'],
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
                description: 'Successful retrieval of the loan object',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetLoanResponse'),
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified loan could not be found',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function get(Route $route, ServerRequestInterface $request);

    #[OAT\Get(
        path: '/loan',
        operationId: 'listLoans',
        summary: 'Fetch a comprehensive list of all registered loans',
        tags: ['Loan'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Successfully retrieved the list of loans',
                content: new OAT\JsonContent(type: 'array', items: new OAT\Items(ref: '#/components/schemas/GetLoanResponse'))
            )
        ]
    )]
    public function list(Route $route, ServerRequestInterface $request);

    #[OAT\Post(
        path: '/loan/create',
        operationId: 'createLoan',
        summary: 'Create a new loan record',
        tags: ['Loan'],
        requestBody: new OAT\RequestBody(
            description: 'Loan object that needs to be created',
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/CreateLoanRequest')
        ),
        responses: [
            new OAT\Response(
                response: 201,
                description: 'Loan successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/GetLoanResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified book could not be found'
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified person could not be found'
            ),
            new OAT\Response(
                response: 400,
                description: 'Invalid request payload; please check the JSON body format',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function create(Route $route, ServerRequestInterface $request);

    #[OAT\Post(
        path: '/loan/return',
        operationId: 'returnBook',
        summary: 'Effectuate the return of the book',
        tags: ['Loan'],
        requestBody: new OAT\RequestBody(
            description: 'Return Book object that needs to be returned',
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/ReturnBookRequest')
        ),
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Loan successfully marked as returned',
                content: new OAT\JsonContent(ref: '#/components/schemas/ReturnBookResponse')
            ),
            new OAT\Response(
                response: 404,
                description: 'The specified loan could not be found',
                content: new OAT\JsonContent(ref: '#/components/schemas/ExceptionResponse')
            )
        ]
    )]
    public function return(Route $route, ServerRequestInterface $request);
}
