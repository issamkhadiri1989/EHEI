<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Line;
use App\Form\LineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * Renders the form that adds the product line using the barcode only.
     *
     * @Route("/", name="default")
     *
     * @param Request                $request The request instance
     * @param EntityManagerInterface $manager The entity manager
     *
     * @return Response The response instance
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $line = new Line();
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);
        if ($form->isSubmitted() === true) {
            if ($form->isValid() === true) {
                $manager->persist($line);
                $manager->flush();

                return $this->redirectToRoute('default');
            }
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
