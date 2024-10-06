<?php

declare(strict_types=1);

namespace People\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouteResult;
use People\Service\PeopleService;

class PeopleHandler implements RequestHandlerInterface
{
    protected $routes;

    protected $peopleService;

    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
        $this->routes = [
            'people.get' => [$this, 'getPeople']
        ];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        return call_user_func($this->routes[$routeName], $request);
    }

    /**
     * @OA\Get(path="/people/{id}",
     *   summary="Obter informações de uma pessoa",
     *   tags={"People"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns People object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/People"),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="People not found"
     *   )
     * )
     */
    public function getPeople(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $user = $this->peopleService->getUser($id);

        $message = 'sim';

        if ($user == null) {
            $message = 'nao';
        }

        return new JsonResponse(
            ['message' => $message]
        );
    }
}
