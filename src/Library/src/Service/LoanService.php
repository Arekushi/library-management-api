<?php

namespace Library\Service;

use App\Abstract\BaseService;
use App\Exception\HttpException;
use App\Exception\NotFoundException;
use Library\Model\Book;
use Library\Model\Loan;
use Library\Repository\BookRepository;
use Library\Repository\LoanRepository;
use Library\Request\CreateLoanRequest;
use Library\Request\ReturnBookRequest;
use Person\Model\Person;
use Person\Repository\PersonRepository;

class LoanService extends BaseService
{
    private $bookRepository;

    private $personRepository;

    private LoanRepository $loanRepository;

    public function __construct(
        LoanRepository $repository,
        BookRepository $bookRepository,
        PersonRepository $personRepository
    ) {
        $this->repository = $repository;
        $this->loanRepository = $repository;
        $this->bookRepository = $bookRepository;
        $this->personRepository = $personRepository;
    }

    /**
     * Creates a new loan record for a specified book and person.
     *
     * This method checks the availability of the specified book and the existence
     * of the person before creating a loan. It throws exceptions if the book or person
     * cannot be found, or if there are no copies of the book available.
     *
     * @param CreateLoanRequest $request The request object containing the loan details.
     *
     * @return Loan The created loan entity.
     *
     * @throws NotFoundException If the specified book or person is not found.
     * @throws HttpException If there are no more copies of the book available.
     */
    public function create($request)
    {
        $bookId = $request->bookId;
        $personId = $request->personId;
        $loanEndDate = $request->loanEndDate;

        /** @var Book $book */
        $book = $this->bookRepository->getById($bookId);

        if ($book == null) {
            throw new NotFoundException('Book not found');
        }

        if ($book->getCopies() == 0) {
            throw new HttpException(
                "There are no more copies of the book: {$book->getTitle()}",
                400
            );
        }

        /** @var Person $person */
        $person = $this->personRepository->getById($personId);

        if ($person == null) {
            throw new NotFoundException('Person not found');
        }

        $loan = new Loan();
        $book->minusOneCopy();
        $loan->setBook($book);
        $loan->setPerson($person);
        $loan->setLoanStartDate(new \DateTimeImmutable());
        $loan->setLoanEndDate(new \DateTimeImmutable($loanEndDate));

        return $this->repository->createOne($loan);
    }

    /**
     * Processes the return of a loaned book.
     *
     * This method retrieves the loan record associated with the specified person and book.
     * It updates the loan record to set the return date and increments the book's available copies.
     * If no matching loan is found, a NotFoundException is thrown.
     *
     * @param ReturnBookRequest $request The request object containing the person and book identifiers.
     *
     * @return bool True if the book was returned on time, false if it was late.
     *
     * @throws NotFoundException If the loan cannot be found for the specified person and book.
     */
    public function returnBook(ReturnBookRequest $request)
    {
        /** @var Loan $loan */
        $loan = $this->loanRepository->getByPersonAndBook(
            $request->personId,
            $request->bookId
        );

        if (!$loan) {
            throw new NotFoundException('Loan not found');
        }

        $dueDate = $loan->getLoanEndDate();
        $returnDate = new \DateTimeImmutable();

        $loan->getLoanEndDate();
        $loan->getBook()->plusOneCopy();
        $loan->setReturnedDate($returnDate);

        $this->loanRepository->editOne($loan);

        return $returnDate < $dueDate;
    }
}
