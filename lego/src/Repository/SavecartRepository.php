<?php

namespace App\Repository;

use App\Entity\Savecart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Savecart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Savecart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Savecart[]    findAll()
 * @method Savecart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavecartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Savecart::class);
    }

    // /**
    //  * @return Savecart[] Returns an array of Savecart objects
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
    public function findOneBySomeField($value): ?Savecart
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
