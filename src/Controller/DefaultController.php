<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     *
     * @param ProductRepository $repository
     * @param Request $request
     *
     * @return Response
     */
    public function index(ProductRepository $repository, Request $request): Response
    {
        $term = $request->query->get('q', null);
        /*$products = $repository->findAll();*/
        $products = $repository->search($term);

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Displays the top menu.
     *
     * @param CategoryRepository $repository
     *
     * @return Response
     */
    public function mainMenu(CategoryRepository $repository): Response
    {
        return $this->render('default/main_menu.html.twig', [
            'categories' => $repository->findAll(),
        ]);
    }
}
