<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * Show product page.
     *
     * @Route("/product/{slug}", name="product")
     *
     * @param Product $product
     * @param ProductRepository $repository
     *
     * @return Response
     */
    public function index(Product $product, ProductRepository $repository): Response
    {
        $products = $repository->findBy([
            'category' => $product->getCategory(),
        ]);

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'related' => $products,
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
