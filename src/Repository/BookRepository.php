<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Gets all books.
     *
     * @return mixed
     */
    public function getAllBooks()
    {
        $qb = $this->createQueryBuilder('b');

        return $qb->getQuery()
            ->getResult();
    }


    /**
     * Gets the books that have been written before year.
     *
     * @param int $before max year
     * @return mixed
     */
    public function getBooksBefore(int $before)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.edition < :year')
            ->setParameter('year', $before);

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * Gets all books of the given book.
     *
     * @param Author $author
     * @return mixed
     */
    public function getBooksByAuthor(Author $author)
    {
        return $this->createQueryBuilder('c')
            ->select()
            ->where('c.author = :a')
            ->setParameter('a', $author)
            ->getQuery()
            ->getResult();
    }

    /**
     * finds books by title part.
     *
     * @param string $title
     * @return mixed
     */
    public function getBooksByTitle(string $title)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb->select()
            ->where($qb->expr()->like('b.title', $qb->expr()->literal('%' . $title . '%')))
            ->getQuery()
            ->getResult();
    }

    /**
     * Books published before the date.
     *
     * @param \DateTime $date
     * @return mixed
     */
    public function booksPublishedAfter(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb->where($qb->expr()->gte('b.pubDate', ':d'))
            ->setParameter('d', $date->format('Y-m-d'))
            ->orderBy('b.pubDate', 'desc')
            ->getQuery()
            ->getResult();
    }
}
