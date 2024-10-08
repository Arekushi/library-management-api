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
    )
    {
        $this->repository = $repository;
        $this->loanRepository = $repository;
        $this->bookRepository = $bookRepository;
        $this->personRepository = $personRepository;
    }

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
