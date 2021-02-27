<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Registration;
use App\Event\NewRegistrationEvent;
use App\Event\OrderPlacedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DefaultController extends AbstractController
{
    /**
     * The index home page.
     *
     * @Route("/", name="default")
     *
     * @param EventDispatcherInterface $dispatcher The event dispatcher
     *
     * @return Response The response instance
     *
     * @throws \Exception
     */
    public function index(EventDispatcherInterface $dispatcher): Response
    {
        $registration = new Registration();
        $registration->setAddress('ipsum lorem dolore')
            ->setBirthDate(new \DateTime('1988-01-05'))
            ->setFullname('Ipsum LOREM')
            ->setPassword('test1234')
            ->setUsername('lorem.dolore');
        $event = new NewRegistrationEvent($registration);
        $dispatcher->dispatch($event, NewRegistrationEvent::NAME);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
