<?php

declare(strict_types=1);

namespace Library\Handler;

use App\Abstract\BaseHandler;
use Library\Request\CreateBookRequest;
use Library\Request\EditBookRequest;
use Library\Response\GetBookResponse;
use Library\Service\BookService;
use Library\Swagger\BookHandlerSwagger;

class BookHandler extends BaseHandler implements BookHandlerSwagger
{
    public function __construct(BookService $bookService)
    {
        $this->service = $bookService;
        $this->routes = [
            'book.get' => [
                'callback' => [$this, 'get'],
                'responseClass' => GetBookResponse::class
            ],
            'book.list' => [
                'callback' => [$this, 'list'],
                'responseClass' => GetBookResponse::class
            ],
            'book.create' => [
                'callback' => [$this, 'create'],
                'responseStatus' => 201,
                'requestClass' => CreateBookRequest::class,
                'responseClass' => GetBookResponse::class
            ],
            'book.delete' => [
                'callback' => [$this, 'delete']
            ],
            'book.put' => [
                'callback' => [$this, 'put'],
                'requestClass' => CreateBookRequest::class,
                'responseClass' => GetBookResponse::class
            ],
            'book.patch' => [
                'callback' => [$this, 'patch'],
                'requestClass' => EditBookRequest::class,
                'responseClass' => GetBookResponse::class
            ]
        ];
    }
}
