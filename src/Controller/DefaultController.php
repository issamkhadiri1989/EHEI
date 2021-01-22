<?php
#src/Controller/DefaultController.php
declare(strict_types=1);

namespace App\Controller;

use App\Exclude\ContactCsv;
use App\Exclude\ContactCsvCache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #src/Controller/DefaultController.php
    /**
     * @Route("/", name="default")
     *
     * @param ContactCsv $contact
     * @return Response
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function index(
        ContactCsvCache $contact
    ): Response {
        $c = $contact->find('756.9229.5966.11');
        dd($c);

        return new Response('');
    }
}

