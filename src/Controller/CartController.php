<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product as ProductEntity;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @var Cart
     */
    private $cartService;

    public function __construct(Cart $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Displays the cart page.
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function cart(): Response
    {
        return $this->render('cart/index.html.twig', [
            'total_incl' => $this->cartService->computeTotalCartAmount(),
        ]);
    }

    /**
     * @Route("/add-to-cart/{slug}", name="add_to_cart")
     *
     * @param ProductEntity $product
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function addToCart(ProductEntity $product): RedirectResponse
    {
        $this->cartService->addToCart($product);
        $this->addFlash('success', 'Product has been added to cart');

        return $this->redirectToRoute('product', ['slug' => $product->getSlug()]);
    }

    /**
     * Clears the cart.
     *
     * @Route("/clear", name="clear")
     *
     * @return RedirectResponse
     */
    public function clearCart(): RedirectResponse
    {
        $this->cartService->clearCart();
        $this->addFlash('success', 'Cart cleared');

        return $this->redirectToRoute('homepage', [], Response::HTTP_FOUND);
    }
}
