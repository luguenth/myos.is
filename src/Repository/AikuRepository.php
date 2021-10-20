<?php

namespace App\Repository;

use App\Entity\Aiku;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aiku|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aiku|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aiku[]    findAll()
 * @method Aiku[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AikuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aiku::class);
    }

    // /**
    //  * @return Aiku[] Returns an array of Aiku objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aiku
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
