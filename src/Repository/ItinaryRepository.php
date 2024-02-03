<?php

namespace App\Repository;

use App\Entity\Itinary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Itinary>
 *
 * @method Itinary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Itinary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Itinary[]    findAll()
 * @method Itinary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItinaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Itinary::class);
    }

//    /**
//     * @return Itinary[] Returns an array of Itinary objects
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

//    public function findOneBySomeField($value): ?Itinary
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
