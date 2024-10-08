<?php

declare(strict_types=1);

namespace Library\Handler;

use App\Abstract\BaseHandler;
use App\Class\Route;
use Library\Request\CreateLoanRequest;
use Library\Request\ReturnBookRequest;
use Library\Response\GetLoanResponse;
use Library\Response\ReturnBookResponse;
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

    /**
     * Creates a new loan record based on the provided request data.
     *
     * This method extracts data from the incoming request, maps it to the
     * CreateLoanRequest object, and calls the LoanService to create a loan.
     * It then maps the resulting loan object to a response class.
     *
     * @param Route $route The route information, including request and response classes.
     * @param ServerRequestInterface $request The incoming server request containing loan details.
     *
     * @return GetLoanResponse The response containing the created loan details.
     *
     * @throws \Exception If there are errors during loan creation (e.g., book or person not found).
     */
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

    /**
     * Processes the return of a loaned book based on the provided request data.
     *
     * This method extracts data from the incoming request, maps it to the
     * ReturnBookRequest object, and calls the LoanService to process the return.
     * It then returns a response indicating whether the book was returned on time.
     *
     * @param Route $route The route information, including request and response classes.
     * @param ServerRequestInterface $request The incoming server request containing return details.
     *
     * @return ReturnBookResponse The response indicating if the book was returned on time.
     *
     * @throws \Exception If the loan cannot be found for the specified person and book.
     */
    public function return(Route $route, ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $requestClass = $route->getRequestClass();
        $request = $this->mapper->map($data, $requestClass);

        $isOnDeadline = $this->service->returnBook($request);

        return new ReturnBookResponse($isOnDeadline);
    }
}
