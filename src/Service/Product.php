<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;

class Product
{
    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ProductRepository  $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * Get all products.
     *
     * @return array
     */
    public function getAllProducts(): array
    {
        return $this->repository
            ->findAll();
    }

    /**
     * Performs the search of products.
     *
     * @param string|null $term
     * @param int         $limit
     *
     * @return mixed
     */
    public function searchProducts(?string $term, int $limit)
    {
        $this->logger->info('search_engine', [
            'mot' => $term,
        ]);

        return $this->repository
            ->search($term, $limit);
    }
}
