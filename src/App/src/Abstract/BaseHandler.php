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

/**
 * Abstract class BaseHandler.
 *
 * This class serves as a base for request handlers in the application, providing
 * methods for handling various HTTP requests (GET, POST, DELETE, etc.)
 * and mapping request and response data using AutoMapper.
 */
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
        /**
         * Handles an incoming server request and returns a JSON response.
         *
         * @param ServerRequestInterface $request The request object containing the request data.
         *
         * @return ResponseInterface The JSON response generated based on the route's callback.
         */
        $route = $this->getRoute($request);

        return new JsonResponse(
            call_user_func($route->getCallback(), $route, $request),
            $route->getResponseStatus()
        );
    }

    /**
     * Retrieves an object by its ID.
     *
     * @param Route $route The route object containing route metadata.
     * @param ServerRequestInterface $request The request object containing the ID in its attributes.
     *
     * @return mixed The mapped response object based on the retrieved data.
     */
    public function get(Route $route, ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $obj = $this->service->getById($id);

        $responseClass = $route->getResponseClass();
        $response = $this->mapper->map($obj, $responseClass);
        return $response;
    }

    /**
     * Retrieves a list of objects.
     *
     * @param Route $route The route object containing route metadata.
     * @param ServerRequestInterface $request The request object.
     *
     * @return mixed The mapped response object containing the list of retrieved objects.
     */
    public function list(Route $route, ServerRequestInterface $request)
    {
        $objs = $this->service->getAll();
        $responseClass = $route->getResponseClass();

        $response = $this->mapper->mapMultiple($objs, $responseClass);
        return $response;
    }

    /**
     * Creates a new object based on the request data.
     *
     * @param Route $route The route object containing route metadata.
     * @param ServerRequestInterface $request The request object containing the data for creation.
     *
     * @return mixed The mapped response object based on the created data.
     */
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

    /**
     * Deletes an object by its ID.
     *
     * @param Route $route The route object containing route metadata.
     * @param ServerRequestInterface $request The request object containing the ID in its attributes.
     *
     * @return DeletedSuccessfullyResponse A response indicating successful deletion.
     */
    public function delete(Route $route, ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->service->delete($id);

        return new DeletedSuccessfullyResponse();
    }

    /**
     * Updates an existing object with the provided data (PUT method).
     *
     * @param Route $route The route object containing route metadata.
     * @param ServerRequestInterface $request The request object containing the data for updating.
     *
     * @return mixed The mapped response object based on the updated data.
     */
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

    /**
     * Partially updates an existing object with the provided data (PATCH method).
     *
     * @param Route $route The route object containing route metadata.
     * @param ServerRequestInterface $request The request object containing the data for updating.
     *
     * @return mixed The mapped response object based on the updated data.
     */
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

    /**
     * Retrieves the current mapper instance.
     *
     * @return AutoMapper The current mapper instance.
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Sets the mapper instance.
     *
     * @param AutoMapper $mapper The mapper instance to set.
     *
     * @return void
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Retrieves the route associated with the incoming request.
     *
     * @param ServerRequestInterface $request The request object to get the route from.
     *
     * @return Route The route object corresponding to the request.
     */
    public function getRoute($request): Route
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        /** @var Route $route */
        $route = $this->mapper->map($this->routes[$routeName], Route::class);

        return $route;
    }
}
