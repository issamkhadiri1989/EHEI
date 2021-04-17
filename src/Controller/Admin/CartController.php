<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Cart;
use App\Form\Type\CartType;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cart",  name="admin_cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     *
     * @param CartRepository $repository the cart repository
     *
     * @return Response the response instance
     */
    public function index(CartRepository $repository): Response
    {
        return $this->render('admin/cart/index.html.twig', [
            'carts' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/view/{id}", name="view")
     *
     * @param Request $request the request instance
     * @param Cart    $cart    the cart entity
     *
     * @return Response the response instance
     */
    public function view(Request $request, Cart $cart): Response
    {
        return $this->render('admin/cart/view.html.twig', [
            'cart' => $cart,
        ]);
    }
}
