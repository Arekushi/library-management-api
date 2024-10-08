<?php

declare(strict_types=1);

namespace App\Abstract;

use App\Aspect\JsonBodyValidatorAspect;
use App\Response\DeletedSuccessfullyResponse;
use App\Utils\HydratorMapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Hydrator\ClassMethodsHydrator;
use Mezzio\Router\RouteResult;

abstract class BasicHandler implements RequestHandlerInterface
{
    /**
     * @var array<string, array {
     *     method: callable,
     *     requestClass?: class-string
     * }>
     */
    protected $routes;

    protected $service;

    #[JsonBodyValidatorAspect()]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $route = $this->getRoute($request);
        return call_user_func($route['callback'], $request);
    }

    public function get(ServerRequestInterface $request)
    {
        $route = $this->getRoute($request);
        $id = $request->getAttribute('id');
        $obj = $this->service->getById($id);

        $responseClass = $route['responseClass'];
        $response = HydratorMapper::map($obj, $responseClass);
        return new JsonResponse($response);
    }

    public function list(ServerRequestInterface $request)
    {
        $route = $this->getRoute($request);
        $objs = $this->service->getAll();
        $responseClass = $route['responseClass'];

        $response = HydratorMapper::mapList($objs, $responseClass);
        return new JsonResponse($response);
    }

    public function create(ServerRequestInterface $request)
    {
        $route = $this->getRoute($request);
        $data = $request->getParsedBody();
        $requestClass = $route['requestClass'];
        $request = HydratorMapper::map($data, $requestClass);

        $obj = $this->service->create($request);

        $responseClass = $route['responseClass'];
        $response = HydratorMapper::map($obj, $responseClass);
        return new JsonResponse($response);
    }

    public function delete(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->service->delete($id);

        return new JsonResponse(new DeletedSuccessfullyResponse());
    }

    public function edit(ServerRequestInterface $request)
    {
        $route = $this->getRoute($request);
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $requestClass = $route['requestClass'];
        $request = HydratorMapper::map($data, $requestClass);

        $obj = $this->service->edit($id, $data);
        $responseClass = $route['responseClass'];
        $response = HydratorMapper::map($obj, $responseClass);
        return new JsonResponse($response);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRoute($request)
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        return $this->routes[$routeName];
    }
}
