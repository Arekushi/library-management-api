<?php

declare(strict_types=1);

namespace Library\Handler;

use App\Abstract\BaseHandler;
use App\Class\Route;
use Library\Request\CreateLoanRequest;
use Library\Request\ReturnBookRequest;
use Library\Response\GetLoanResponse;
use Library\Response\ReturnBookResponse;
use Library\Service\BookService;
use Library\Service\LoanService;
use Library\Swagger\LoanHandlerSwagger;
use Psr\Http\Message\ServerRequestInterface;

class LoanHandler extends BaseHandler implements LoanHandlerSwagger
{
    public function __construct(LoanService $loanService)
    {
        $this->service = $loanService;
        $this->routes = [
            'loan.get' => [
                'callback' => [$this, 'get'],
                'responseClass' => GetLoanResponse::class
            ],
            'loan.list' => [
                'callback' => [$this, 'list'],
                'responseClass' => GetLoanResponse::class
            ],
            'loan.create' => [
                'callback' => [$this, 'create'],
                'responseStatus' => 201,
                'requestClass' => CreateLoanRequest::class,
                'responseClass' => GetLoanResponse::class
            ],
            'loan.return' => [
                'callback' => [$this, 'return'],
                'requestClass' => ReturnBookRequest::class,
                'responseClass' => ''
            ]
        ];
    }

    public function create(Route $route, ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $requestClass = $route->getRequestClass();

        /** @var CreateLoanRequest $request */
        $request = $this->mapper->map($data, $requestClass);

        $obj = $this->service->create($request);
        $responseClass = $route->getResponseClass();
        $response = $this->mapper->map($obj, $responseClass);
        return $response;
    }

    public function return(Route $route, ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $requestClass = $route->getRequestClass();
        $request = $this->mapper->map($data, $requestClass);

        $isOnDeadline = $this->service->returnBook($request);

        return new ReturnBookResponse($isOnDeadline);
    }
}
