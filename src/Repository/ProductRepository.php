<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Searches products by a given term either by title or short description.
     *
     * @param string|null $term
     *
     * @return mixed
     */
    public function search(?string $term)
    {
        $qb = $this->createQueryBuilder('p');
        $expr = $qb->expr();
        $orCondition = $expr->orX(
            $expr->like('p.title', ':x'),
            $expr->like('p.shortDescription', ':x')
        );

        return $qb->where($orCondition)
            ->setParameter('x', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }
}
