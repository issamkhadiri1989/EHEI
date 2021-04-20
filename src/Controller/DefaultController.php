<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Order;
use App\Form\Type\OrderLineType;
use App\Form\Type\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/collection-type", name="default")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(OrderLineType::class, $item);

        /*$order = new Order();
        $order->setStatus(Order::ORDER_CREATED)
            ->setCreationDate(new \DateTime());
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);*/

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
