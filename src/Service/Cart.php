<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart as CartEntity;
use App\Entity\CartLine;
use App\Entity\Product as Item;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This service aims to  manage the cart.
 */
class Cart
{
    const CART_NO_SET = 'cart not set';

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
    /**
     * @var EntityManagerInterface
     */
    private $oracleManager;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Product
     */
    private $productService;

    public function __construct(int $vat, string $from, EntityManagerInterface $oracleManager)
    {
        $this->vat = $vat;
        $this->from = $from;
        $this->oracleManager = $oracleManager;
    }

    /**
     * @required
     * @param Product $productService
     */
    public function setProductService(Product $productService): void
    {
        $this->productService = $productService;
    }

    public function __toString(): string
    {
        $products = $this->productService->getAllProducts();

        return \sprintf(
            'This is Cart service : %d products',
            \count($products)
        );
    }

    /**
     * @required
     * @param SessionInterface $session
     * @param LoggerInterface $logger
     */
    public function injectServices(SessionInterface $session, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * Adds a product to the cart.
     *
     * @param Item $product
     *
     * @throws \Exception
     */
    public function addToCart(CartLine $product): void
    {
        $cart = null;
        if ($this->isCartEmpty() === true) {
            $cart = $this->createNewCart();
            $this->session->set('cart', $cart);
        } else {
            /** @var CartEntity $cart */
            $cart = $this->session->get('cart');
        }
        $cart->addCartLine($product);
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
     * @return CartEntity
     */
    public function getCurrentCart(): CartEntity
    {
        if (!$this->isCartEmpty()) {
            return $this->session
                ->get('cart');
        }

        throw new NotFoundHttpException(self::CART_NO_SET);
    }

    /**
     * @param CartEntity $cart the new cart state
     */
    public function updateCart(CartEntity $cart): void {
        if (!$this->isCartEmpty()) {
            $this->session->set('cart', $cart);
        } else {
            throw new NotFoundHttpException(self::CART_NO_SET);
        }
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
