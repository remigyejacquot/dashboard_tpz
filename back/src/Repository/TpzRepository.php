<?php

namespace App\Repository;

use App\Entity\Tpz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tpz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tpz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tpz[]    findAll()
 * @method Tpz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TpzRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tpz::class);
    }

    // /**
    //  * @return Tpz[] Returns an array of Tpz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tpz
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
