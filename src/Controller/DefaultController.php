<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Shipping;
use App\Form\ShippingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $shipping = new Shipping();
        $form = $this->createForm(ShippingType::class, $shipping);
        $form->handleRequest($request);

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
