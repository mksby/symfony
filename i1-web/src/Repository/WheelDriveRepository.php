<?php

namespace App\Repository;

use App\Entity\WheelDrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WheelDrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method WheelDrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method WheelDrive[]    findAll()
 * @method WheelDrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WheelDriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WheelDrive::class);
    }

    // /**
    //  * @return WheelDrive[] Returns an array of WheelDrive objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WheelDrive
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
