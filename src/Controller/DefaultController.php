<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\Cart;
use App\Service\Mailer;
use App\Service\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var Product
     */
    private $productService;

    /**
     * @var Cart
     */
    private $cartService;

    public function __construct(Product $productService, Cart $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    /**
     * Displays the home page.
     *
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $term = $request->query->get('q', null);
        $products = $this->productService->searchProducts($term);

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Displays the top menu.
     *
     * @param CategoryRepository $repository
     *
     * @return Response
     */
    public function mainMenu(CategoryRepository $repository): Response
    {
        return $this->render('default/main_menu.html.twig', [
            'categories' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/index", name="all_products")
     */
    public function allIndex(): Response
    {
        $this->container->get(Cart::class);

        $products = $this->productService->getAllProducts();

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/send-mail", name="send_mail")
     *
     * @param Mailer $mailer the service mailer
     */
    public function sendMail(Mailer $mailer)
    {
        $mailer->sendMail();
        die;
    }
}
