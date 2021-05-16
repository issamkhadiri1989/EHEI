<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\CartLine;
use App\Entity\Product as ProductEntity;
use App\Event\OrderPlaced;
use App\Form\Type\CartType;
use App\Form\Type\CheckoutType;
use App\Repository\ProductRepository;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    const CART_UPDATED = 'Cart updated';
    const PRODUCT_ADDED = 'Product has been added to the cart';
    const CART_CLEARED = 'Cart cleared';
    const OPERATION_NOT_ALLOWED = 'Operation not allowed';
    const CART_CHECKED_OUT = 'Cart checked out';

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
     * @param Request $request
     *
     * @return Response
     */
    public function cart(Request $request): Response
    {
        $cart = $this->cartService->getCurrentCart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->cartService->updateCart($cart);
            $this->addFlash('success', self::CART_UPDATED);

            return $this->redirectToRoute('cart_homepage', [], Response::HTTP_FOUND);
        }

        return $this->render('cart/index.html.twig', [
            'total_incl' => $this->cartService->computeTotalCartAmount(),
            'form' => $form->createView(),
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
        $this->addFlash('success', self::PRODUCT_ADDED);

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
        $this->addFlash('success', self::CART_CLEARED);

        return $this->redirectToRoute('homepage', [], Response::HTTP_FOUND);
    }

    /**
     * @Route("/checkout", name="checkout")
     *
     * @param Request                $request    the request object
     * @param ProductRepository      $repository the product repository
     * @param EntityManagerInterface $manager    the entity manager
     *
     * @return Response the response
     */
    public function checkout(Request $request, ProductRepository $repository, EntityManagerInterface $manager, EventDispatcherInterface $dispatcher)
    {
        if ($this->cartService->isCartEmpty()) {
            throw new AccessDeniedHttpException(self::OPERATION_NOT_ALLOWED);
        }
        $cart = $this->cartService->getCurrentCart();
        $manager->persist($cart);
        $form = $this->createForm(CheckoutType::class, $cart);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CartLine $cartLine */
            foreach ($cart->getCartLines() as $cartLine) {
                $product = $repository->find($cartLine->getProduct());
                $cartLine->setProduct($product);
                $cartLine->setCart($cart);
                $manager->persist($cartLine);
            }
            $manager->flush();
            $this->cartService->clearCart();
            $this->addFlash('success', self::CART_CHECKED_OUT);
            $event = new OrderPlaced($cart);
            $dispatcher->dispatch($event, OrderPlaced::NAME);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('cart/checkout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
