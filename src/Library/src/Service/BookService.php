<?php

namespace Library\Service;

use App\Abstract\BaseService;
use Library\Repository\BookRepository;

class BookService extends BaseService
{
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }
}
