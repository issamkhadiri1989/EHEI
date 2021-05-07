<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\Type\CartLineType;
use App\Form\Type\ContactType;
use App\Model\Contact;
use App\Repository\ProductRepository;
use App\Service\Cart;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;
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
     * @param Pusher            $pusher
     *
     * @return Response
     *
     * @throws ApiErrorException
     * @throws PusherException
     */
    public function index(Product $product, ProductRepository $repository, Request $request, Pusher $pusher): Response
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

        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // ... Pusher
            $data['name'] = $contact->getName();
            $data['email'] = $contact->getEmail();
            $data['message'] = $contact->getMessage();
            $data['url'] = $this->generateUrl('admin_product_edit', ['id' => $product->getId()]);
            // ... save to database
            $data['success'] = false;
            $pusher->trigger('my-channel', 'my-event', $data);
            $this->addFlash(
                'warning',
                'Your message has been sent. However, we need to review it before publishing it'
            );

            return $this->redirectToRoute('product', ['slug' => $product->getSlug()]);
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'related' => $products,
            'addToCart' => $form->createView(),
            'contactForm' => $contactForm->createView(),
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
