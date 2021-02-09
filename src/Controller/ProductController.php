<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{slug}", name="product")
     *
     * @param Product                $product    The product to be added to the cart
     * @param Request                $request    The request object
     * @param SessionInterface       $session    A session instance
     * @param CartRepository         $repository The cart repository
     * @param EntityManagerInterface $manager    The entity manager instance
     *
     * @return Response A response instance
     *
     * @throws \Exception
     */
    public function index(
        Product $product,
        Request $request,
        SessionInterface $session,
        CartRepository $repository,
        EntityManagerInterface $manager
    ): Response {
        $cart = null;
        if ($session->has('CART') === true) {
            $cart = $repository->find($session->get('CART'));
        } else {
            $cart = new Cart();
            $cart->setCreateDate(new \DateTime())
                ->setStatus(Cart::CART_INITIATED);
            $manager->persist($cart);
        }
        $line = new CartLine();
        $line->setProduct($product);
        $form = $this->createForm(AddToCartType::class, $line);
        $form->handleRequest($request);
        if ($form->isSubmitted() === true) {
            if ($form->isValid() === true) {
                $line->setCart($cart);
                $manager->persist($line);
                $manager->flush();
                $session->set('CART', $cart->getId());
                $this->addFlash('success', 'Added to cart');

                return $this->redirectToRoute('product', ['slug' => $product->getSlug(),]);
            }
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
