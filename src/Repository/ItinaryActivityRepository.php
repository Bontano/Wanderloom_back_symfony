<?php

namespace App\Repository;

use App\Entity\ItinaryActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItinaryActivity>
 *
 * @method ItinaryActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItinaryActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItinaryActivity[]    findAll()
 * @method ItinaryActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItinaryActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItinaryActivity::class);
    }

//    /**
//     * @return ItinaryActivity[] Returns an array of ItinaryActivity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItinaryActivity
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
