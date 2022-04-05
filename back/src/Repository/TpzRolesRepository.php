<?php

namespace App\Repository;

use App\Entity\TpzRoles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TpzRoles|null find($id, $lockMode = null, $lockVersion = null)
 * @method TpzRoles|null findOneBy(array $criteria, array $orderBy = null)
 * @method TpzRoles[]    findAll()
 * @method TpzRoles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TpzRolesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TpzRoles::class);
    }

    // /**
    //  * @return TpzRoles[] Returns an array of TpzRoles objects
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
    public function findOneBySomeField($value): ?TpzRoles
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
