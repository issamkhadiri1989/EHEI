<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * Fetch all studios and Apartments and having price less than $maxPrice.
     *
     * @param float $maxPrice max rent price
     *
     * @return mixed
     */
    public function getStudiosAndApartments(float $maxPrice)
    {
        $qb = $this->createQueryBuilder('a');

        $typeCondition = $qb->expr()
            ->orX(
                $qb->expr()->eq('a.propertyType', $qb->expr()->literal('Studio')),
                $qb->expr()->eq('a.propertyType', $qb->expr()->literal('Apartment'))
            );
        $priceCondition = $qb->expr()->lte('a.price', ':maxPrice');

        $condition = $qb->expr()
            ->andX($typeCondition, $priceCondition);

        return $qb->where($condition)
            ->setParameter('maxPrice', $maxPrice)
            ->getQuery()
            ->getResult();
    }

    /**
     * Gets the list of properties according to given types.
     *
     * @param array $types types of the properties
     *
     * @return mixed Set of properties
     */
    public function getRentalsByTypes(array $types)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb->where($qb->expr()->in('p.propertyType', $types))
            ->getQuery()
            ->getResult();
    }

    /**
     * Counts the number of properties according to the types.
     *
     * @param array $types given set of types
     *
     * @return mixed total number of properties
     * 
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countAllProperties(array $types)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb->select('count(p) as total')
            ->where($qb->expr()->in('p.propertyType', $types))
            ->getQuery()
            ->getSingleScalarResult();
    }
}
