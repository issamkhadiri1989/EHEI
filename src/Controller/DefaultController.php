<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Order;
use App\Form\Type\OrderLineType;
use App\Form\Type\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/collection-type", name="default")
     * @Route("/collection-type/edit/{id}", name="edit_collection_type")
     *
     * @param Request                $request
     * @param EntityManagerInterface $manager
     * @param Order|null             $order
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function index(Request $request, EntityManagerInterface $manager, ?Order $order = null): Response
    {
        if (null === $order) {
            $order = new Order();
            $order->setStatus(Order::ORDER_CREATED)
                ->setCreationDate(new \DateTime());
        }
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($order->getItems() as $item) {
                $item->setDish($order);
                $manager->persist($item);
            }
            $manager->persist($order);
            $manager->flush();

            return $this->redirectToRoute('edit_collection_type', ['id' => $order->getId()]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
