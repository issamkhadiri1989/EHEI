<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * Fetching books edited between 2 years.
     *
     * @Route("/all", name="all_books")
     *
     * @param BookRepository $repository the repository instance
     *
     * @return Response The response instance
     */
    public function booksInPeriod(BookRepository $repository): Response
    {
        $books = $repository->getBooksBefore(2010);

        return $this->render('default/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * Action that finds the books.
     *
     * @Route("/search", name="search")
     *
     * @param Request        $request    the request object
     * @param BookRepository $repository the repository instance
     *
     * @return Response the response instance
     */
    public function search(Request $request, BookRepository $repository): Response
    {
        $q = $request->query->get('q');
        $books = $repository->getBooksByTitle($q);

        return $this->render('default/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * Retrieves the books published after a given date.
     *
     * @Route("/books/after", name="books_after")
     *
     * @param BookRepository $repository the repository instance
     *
     * @return Response the response instance
     *
     * @throws \Exception
     */
    public function booksAfter(BookRepository $repository): Response
    {
        $books = $repository->booksPublishedAfter(new \DateTime('2010-01-01'));

        return $this->render('default/index.html.twig', [
            'books' => $books,
        ]);
    }
}
