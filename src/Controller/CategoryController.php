<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * Displays products by category.
     *
     * @Route("/category/{slug}", name="category")
     *
     * @param Category $category
     *
     * @return Response
     */
    public function index(Category $category): Response
    {
        return $this->render('default/index.html.twig', [
            'products' => $category->getProducts(),
        ]);
    }

    /**
     * Displays all categories product counts.
     *
     * @param CategoryRepository $repository
     *
     * @return Response
     */
    public function categories(CategoryRepository $repository): Response
    {
        return $this->render('category/categories.html.twig', [
            'categories' => $repository->findAll(),
        ]);
    }
}
