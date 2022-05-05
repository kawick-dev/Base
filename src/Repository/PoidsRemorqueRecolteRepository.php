<?php

namespace App\Repository;

use App\Entity\PoidsRemorqueRecolte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PoidsRemorqueRecolte>
 *
 * @method PoidsRemorqueRecolte|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoidsRemorqueRecolte|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoidsRemorqueRecolte[]    findAll()
 * @method PoidsRemorqueRecolte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoidsRemorqueRecolteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoidsRemorqueRecolte::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PoidsRemorqueRecolte $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PoidsRemorqueRecolte $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PoidsRemorqueRecolte[] Returns an array of PoidsRemorqueRecolte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PoidsRemorqueRecolte
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
