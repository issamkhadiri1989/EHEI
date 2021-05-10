<?php

namespace App\Repository;

use App\Entity\CirculationTax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CirculationTax|null find($id, $lockMode = null, $lockVersion = null)
 * @method CirculationTax|null findOneBy(array $criteria, array $orderBy = null)
 * @method CirculationTax[]    findAll()
 * @method CirculationTax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CirculationTaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CirculationTax::class);
    }

    // /**
    //  * @return CirculationTax[] Returns an array of CirculationTax objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CirculationTax
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
