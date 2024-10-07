<?php

declare(strict_types=1);

namespace App\Abstract;

use App\Aspect\JsonBodyValidatorAspect;
use App\Exception\InvalidJsonBodyException;
use App\Service\BasicService;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\ReflectionHydrator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouteResult;
use Symfony\Component\Validator\Validation;

use ReflectionFunction;
use ReflectionMethod;
use ReflectionParameter;

class BasicHandler implements RequestHandlerInterface
{
    /**
     * @var array<string, array{
     *     method: callable,
     *     requestClass?: class-string
     * }>
     */
    protected $routes;

    protected $service;

    #[JsonBodyValidatorAspect(method: 'validate')]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        $route = $this->routes[$routeName];

        return call_user_func($route['callback'], $request);
    }

    public function get(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        // $user = $this->service->get($id);

        // $message = 'sim';

        // if ($user == null) {
        //     $message = 'nao';
        // }

        return new JsonResponse(
            ['message' => $id]
        );
    }

    public function create(ServerRequestInterface $request)
    {
        // $data = $request->getParsedBody();
        // $person = new CreatePersonRequest($data['name'],  $data['email']);
        return new JsonResponse(['message' => 'a']);
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
