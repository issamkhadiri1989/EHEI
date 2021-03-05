<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * Finds the authors that wrote the given books' type.
     *
     * @param Category $type can be any book category
     *
     * @return mixed
     */
    public function findAuthorsWriting(Category $type)
    {
        $qb = $this->createQueryBuilder('a');

        return $qb->select('a')
            ->distinct()
            ->join(Book::class, 'b', 'WITH', 'b.author=a.id')
            ->where('b.category = :category')
            ->setParameter('category', $type)
            ->getQuery()
            ->getResult();
    }
}
