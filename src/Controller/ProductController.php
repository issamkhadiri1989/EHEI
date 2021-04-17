<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\Type\CartLineType;
use App\Repository\ProductRepository;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
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
     * Show product page.
     *
     * @Route("/product/{slug}", name="product")
     *
     * @param Product           $product
     * @param ProductRepository $repository
     * @param Request           $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function index(Product $product, ProductRepository $repository, Request $request): Response
    {
        $products = $repository->findBy([
            'category' => $product->getCategory(),
        ]);

        $cartLine = new CartLine();
        $cartLine->setQuantity(1)
            ->setProduct($product);
        $form = $this->createForm(CartLineType::class, $cartLine);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->cartService->addToCart($cartLine);
            $this->addFlash('success', 'Product added to cart');

            return $this->redirectToRoute('cart_homepage', [], Response::HTTP_FOUND);
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'related' => $products,
            'addToCart' => $form->createView(),
        ]);
    }

    /**
     * Retrieves the featured tagged product.
     *
     * @param ProductRepository $repository
     *
     * @return Response
     */
    public function getFeaturedProduct(ProductRepository $repository)
    {
        return $this->render('product/featured_product.html.twig', [
            'featured' => $repository->findOneBy(['featured' => true]),
        ]);
    }
}
