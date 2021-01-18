<?php
#src/Controller/DefaultController.php
declare(strict_types=1);

namespace App\Controller;

use App\Service\IdGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     *
     * @param LoggerInterface $logger    The logger object
     * @param IdGenerator     $generator The generator of ids
     *
     * @return Response
     */
    public function index(LoggerInterface $logger, IdGenerator $generator): Response
    {
        //...do something with the logger like $logger->info()
        return new Response($generator->generateId());
    }
}

