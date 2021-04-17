<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product", name="admin_product_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     * @Route("/edit/{id}", name="edit")
     *
     * @param Request                $request the request object
     * @param EntityManagerInterface $manager the entity manager
     * @param Product|null           $product the product
     *
     * @return Response the edit page
     */
    public function manage(Request $request, EntityManagerInterface $manager, ?Product $product = null)
    {
        if (null === $product) {
            $product = new Product();
        }
        $form = $this->makeProductForm($product);
        if (true === $this->processForm($product, $request, $manager, $form)) {
            return $this->redirectToRoute('admin_product_edit', ['id' => $product->getId()]);
        }

        return $this->render('admin/product/manage.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/", name="homepage")
     *
     * @param ProductRepository $repository the repository  instance
     *
     * @return Response the response object
     */
    public function index(ProductRepository $repository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $repository->findAll(),
        ]);
    }

    /**
     * @param Product $product the product object
     *
     * @return FormInterface the resulting form
     */
    private function makeProductForm(Product $product): FormInterface
    {
        $options = [];
        if (null !== $product->getSlug()) {
            $options['slug'] = $product->getSlug();
        }

        return $this->createForm(ProductType::class, $product, $options);
    }

    /**
     * @param Product                $product the product object
     * @param Request                $request the request instance
     * @param EntityManagerInterface $manager the entity manager
     * @param FormInterface          $form    the form
     *
     * @return bool
     */
    private function processForm(
        Product $product,
        Request $request,
        EntityManagerInterface $manager,
        FormInterface $form
    ): bool {
        $form->handleRequest($request);
        $successMessage = $product->getId() === null ? 'The product has been added.' : 'The product has been updated.';
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', $successMessage);

            return true;
        }

        return false;
    }
}
