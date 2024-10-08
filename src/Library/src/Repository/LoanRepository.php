<?php

namespace Library\Repository;

use App\Abstract\BaseRepository;

class LoanRepository extends BaseRepository
{
    /**
     * Retrieves a loan record by the specified person and book IDs.
     *
     * This method fetches a loan entry that matches the provided person and book UUIDs.
     * If no matching loan is found, it returns null.
     *
     * @param string $personId The UUID of the person associated with the loan.
     * @param string $bookId   The UUID of the book associated with the loan.
     *
     * @return mixed|null The loan entity if found, or null if no matching loan exists.
     */
    public function getByPersonAndBook($personId, $bookId)
    {
        $obj = $this->select()
            ->where(['person_uuid' => $personId])
            ->where(['book_uuid' => $bookId])
            ->fetchOne();

        return $obj;
    }
}
