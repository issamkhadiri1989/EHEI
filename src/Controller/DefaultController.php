<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Home page.
     *
     * @Route("/", name="default")
     *
     * @param BookRepository $repository the repository instance
     *
     * @return  Response the response instance
     */
    public function index(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('default/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * Gets all categories.
     *
     * @param CategoryRepository $repository the repository
     *
     * @return Response the response instance
     */
    public function categories(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('default/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
