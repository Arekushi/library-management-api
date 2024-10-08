<?php

declare(strict_types=1);

namespace App\Abstract;

use App\Aspect\JsonBodyValidatorAspect;
use App\Class\Route;
use App\Response\DeletedSuccessfullyResponse;
use AutoMapperPlus\AutoMapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Hydrator\ClassMethodsHydrator;
use Mezzio\Router\RouteResult;

abstract class BaseHandler implements RequestHandlerInterface
{
    /**
     * @var array<string, array{
     *     callback: callable,                  // A callback function to handle the route
     *     requestClass?: class-string|null,    // Optional: The class name for the request data structure
     *     responseClass?: class-string|null,   // Optional: The class name for the response data structure
     *     responseStatus?: int                 // Optional: The HTTP status code to return (default is 200)
     * }>
     */
    protected $routes;

    protected $service;

    protected AutoMapper $mapper;

    #[JsonBodyValidatorAspect()]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $route = $this->getRoute($request);

        return new JsonResponse(
            call_user_func($route->getCallback(), $route, $request),
            $route->getResponseStatus()
        );
    }

    public function get(Route $route, ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $obj = $this->service->getById($id);

        $responseClass = $route->getResponseClass();
        $response = $this->mapper->map($obj, $responseClass);
        return $response;
    }

    public function list(Route $route, ServerRequestInterface $request)
    {
        $objs = $this->service->getAll();
        $responseClass = $route->getResponseClass();

        $response = $this->mapper->mapMultiple($objs, $responseClass);
        return $response;
    }

    public function create(Route $route, ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $requestClass = $route->getRequestClass();
        $request = $this->mapper->map($data, $requestClass);

        $obj = $this->service->create($request);

        $responseClass = $route->getResponseClass();
        $response = $this->mapper->map($obj, $responseClass);
        return $response;
    }

    public function delete(Route $route, ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->service->delete($id);

        return new DeletedSuccessfullyResponse();
    }

    public function put(Route $route, ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $requestClass = $route->getRequestClass();
        $request = $this->mapper->map($data, $requestClass);

        $obj = $this->service->edit($id, $data, true);
        $responseClass = $route->getResponseClass();
        $response = $this->mapper->map($obj, $responseClass);
        return $response;
    }

    public function patch(Route $route, ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $requestClass = $route->getRequestClass();
        $request = $this->mapper->map($data, $requestClass);

        $obj = $this->service->edit($id, $data);
        $responseClass = $route->getResponseClass();
        $response = $this->mapper->map($obj, $responseClass);
        return $response;
    }

    public function getMapper()
    {
        return $this->mapper;
    }

    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }

    public function getRoute($request): Route
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        /** @var Route $route */
        $route = $this->mapper->map($this->routes[$routeName], Route::class);

        return $route;
    }
}
