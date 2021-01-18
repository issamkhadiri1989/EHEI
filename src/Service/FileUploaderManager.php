<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class FileUploaderManager
{
    /**
     * @var string
     */
    private $mediaDirectory;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        string $mediaDirectory,
        EntityManagerInterface $manager,
        LoggerInterface $logger
    ) {
        $this->mediaDirectory = $mediaDirectory;
        $this->manager = $manager;
        $this->logger = $logger;
    }

    // ... some methods that may use the $mediaDirectory property to read or store medias
    // ... and why not use the $manager to persist data in the database
}