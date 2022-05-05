<?php

namespace App\Repository;

use App\Entity\Epandage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Epandage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Epandage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Epandage[]    findAll()
 * @method Epandage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpandageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Epandage::class);
    }

    // /**
    //  * @return Epandage[] Returns an array of Epandage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Epandage
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
