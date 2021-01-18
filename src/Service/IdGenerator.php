<?php
#src/Service/IdGenerator.php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class IdGenerator
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $manager, LoggerInterface $logger)
    {
        $this->manager = $manager;
        $this->logger = $logger;
    }

    public function saveToDataBase(/*Some arguments*/)
    {
        /*
         * ...Some logic in this function
         * To use the injected Service:
         *
         * $this->manager->persist($object);
         * $this->manager->flush();
         *
         * Besides, we also need to log some data into log files.
         * $this->logger->inf('Message', ...)
         *
         */
    }


    /**
     * Generates a random ID.
     *
     * @param int $length The length of the generated string
     *
     * @return string The generated Id
     */
    public function generateId(int $length = 10): string
    {
        $id = '';
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $id .= $alphabet[\mt_rand(0, \strlen($alphabet))];
        }

        return $id;
    }
}
