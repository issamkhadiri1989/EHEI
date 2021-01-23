<?php

declare(strict_types=1);

namespace App\Controller;

use App\Mail\TransportChain;
use App\Service\FileReaderCollector;
use App\Service\MainFileReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     *
     * @param MainFileReader $reader
     */
    public function index(MainFileReader $reader)
    {
        $reader->dump();
        echo "App launched successfully";
        die;
    }

    /**
     * @Route("/collect", name="collector")
     *
     * @param FileReaderCollector $collector
     */
    public function collector(FileReaderCollector $collector)
    {
        $collector->dump();
        die;
    }
}