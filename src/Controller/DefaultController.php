<?php

namespace App\Controller;

use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository): Response
    {
        $products = $repository->findAll();

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/cart", name="cart")
     *
     * @param SessionInterface $session
     * @param CartRepository $repository
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function chart(SessionInterface $session, CartRepository $repository, Request $request, EntityManagerInterface $manager): Response
    {
        $cart = null;
        if ($session->has('CART') === true) {
            $cart = $repository->find($session->get('CART'));
        }
        if (null === $cart) {
            throw new $this->createNotFoundException();
        }

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);
        if ($form->isSubmitted() === true) {
            if ($form->isValid() === true) {
                $manager->persist($cart);
                $manager->flush();
            }
        }

        return $this->render('default/cart.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }
}
