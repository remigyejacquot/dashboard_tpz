<?php

namespace App\Repository;

use App\Entity\Subtask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subtask|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subtask|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subtask[]    findAll()
 * @method Subtask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubtaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subtask::class);
    }

    // /**
    //  * @return Subtask[] Returns an array of Subtask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subtask
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
