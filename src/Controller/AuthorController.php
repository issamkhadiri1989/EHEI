<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Category;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * Gets books by author.
     *
     * @Route("/authors/{slug}/books", name="books_author")
     *
     * @param BookRepository $repository the repository instance
     * @param Author         $author     the author object
     *
     * @return Response the response instance
     */
   public function index(BookRepository $repository, Author $author): Response
   {
       $books = $repository->getBooksByAuthor($author);

       return $this->render('default/index.html.twig', [
           'books' => $books,
       ]);
   }

    /**
     * List all the authors.
     *
     * @Route("/authors", name="home_author")
     *
     * @param AuthorRepository $repository the repository instance
     *
     * @return Response the response instance
     */
   public function getAuthors(AuthorRepository $repository): Response
   {
       $authors = $repository->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
   }

    /**
     * Finds the authors who wrote the specific books' type.
     *
     * @Route("/authors/{slug}/similar-books", name="horror_books")
     *
     * @param AuthorRepository $repository the repository instance
     * @param Category         $category   the category instance
     *
     * @return Response The response instance
     */
   public function getAuthorsByType(AuthorRepository $repository, Category $category): Response
   {
       $authors = $repository->findAuthorsWriting($category);

       return $this->render('author/index.html.twig', [
           'authors' => $authors,
       ]);
   }
}
