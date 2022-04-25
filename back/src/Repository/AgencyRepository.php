<?php

namespace App\Repository;

use App\Entity\Agency;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Cast\Bool_;

/**
 * @method Agency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agency[]    findAll()
 * @method Agency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agency::class);
    }

    // /**
    //  * @return Agency[] Returns an array of Agency objects
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
    public function findOneBySomeField($value): ?Agency
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param User $user
     * @return Agency[]|null
     */
    public function retrieveUserTypeAgencies(User $user) : ?array
    {
        return $this->createQueryBuilder('agency')
            ->andWhere('agency.is_dev = :is_dev')
            ->setParameter('is_dev', $user->getIsDev())
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Agency[]|null
     */
    public function retrieveAgencies($type) : ?array
    {
        return $this->createQueryBuilder('agency')
            ->andWhere('agency.is_dev = :is_dev')
            ->setParameter('is_dev', $type)
            ->getQuery()
            ->getResult()
            ;
    }
}
