<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
        ]);
    }

    /**
     * Displays a set of articles randomly. This action is not reachable via a route.
     *
     * @param int $max The max iterations
     *
     * @return Response The response
     */
    public function display(int $max = 3): Response
    {
        return $this->render('default/articles.html.twig', [
            'max' => $max,
        ]);
    }
}
