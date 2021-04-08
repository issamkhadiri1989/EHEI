<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart as CartEntity;
use App\Entity\CartLine;
use App\Entity\Product as Item;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * This service aims to  manage the cart.
 */
class Cart
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var int
     */
    private $vat;
    /**
     * @var string
     */
    private $from;

    public function __construct(SessionInterface $session, int $vat, string $from)
    {
        $this->session = $session;
        $this->vat = $vat;
        $this->from = $from;
    }

    /**
     * Adds a product to the cart.
     *
     * @param Item $product
     *
     * @throws \Exception
     */
    public function addToCart(Item $product): void
    {
        $cart = null;
        if ($this->isCartEmpty() === true) {
            $cart = $this->createNewCart();
            $this->session->set('cart', $cart);
        } else {
            /** @var CartEntity $cart */
            $cart = $this->session->get('cart');
        }
        $this->addItemToCart($cart, $product);
        $this->updateCart($cart);
    }

    /**
     * Adds a new product to cart.
     *
     * @param CartEntity $cart
     * @param Item       $product
     */
    public function addItemToCart(CartEntity  $cart, Item $product): void
    {
        $cart->addCartLine((new CartLine())
            ->setProduct($product)
            ->setQuantity(1));
    }

    /**
     * Updates the current cart state.
     *
     * @param CartEntity $cart
     */
    public function updateCart(CartEntity $cart): void
    {
        $this->session->set('cart', $cart);
    }

    /**
     * Clears the cart.
     */
    public function clearCart(): void
    {
        if ($this->isCartEmpty() === false) {
            $this->session->set('cart', null);
        }
    }

    /**
     * Checks if the cart is empty or not already set.
     *
     * @return bool
     */
    public function isCartEmpty(): bool
    {
        return (!$this->session->has('cart') || $this->session->get('cart') === null);
    }

    /**
     * Computes the total amount of the current cart.
     *
     * @return float total of the current cart
     */
    public function computeTotalCartAmount(): float
    {
        if ($this->isCartEmpty() === true) {
            return 0.0;
        }

        $total = 0.0;

        /** @var CartEntity $cart */
        $cart = $this->session->get('cart');
        /** @var CartLine $item */
        foreach ($cart->getCartLines() as $item) {
            $lineTotal = $item->getProduct()->getPrice() * $item->getQuantity();
            $total += ($lineTotal* (1+(0.01*$this->vat)));
        }

        return $total;
    }

    /**
     * Creates new cart.
     *
     * @return CartEntity
     *
     * @throws \Exception
     */
    private function createNewCart(): CartEntity
    {
        return (new CartEntity())
            ->setCreatedAt(new \DateTime())
            ->setStatus(CartEntity::CART_CREATED);
    }
}
