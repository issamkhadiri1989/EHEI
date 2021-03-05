<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * Find books by a given category.
     *
     * @Route("/category/{slug}/books", name="category")
     *
     * @param Category       $category   The category object
     * @param BookRepository $repository The repository instance
     *
     * @return Response the response instance
     */
    public function index(Category $category, BookRepository $repository): Response
    {
        $books = $repository->findBy([
            'category' => $category,
        ]);

        return $this->render('default/index.html.twig', [
            'books' => $books,
        ]);
    }
}
