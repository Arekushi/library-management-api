<?php

namespace Library\Repository;

use App\Abstract\BaseRepository;

class LoanRepository extends BaseRepository
{
    public function getByPersonAndBook($personId, $bookId)
    {
        $obj = $this->select()
            ->where(['person_uuid' => $personId])
            ->where(['book_uuid' => $bookId])
            ->fetchOne();

        return $obj;
    }
}
