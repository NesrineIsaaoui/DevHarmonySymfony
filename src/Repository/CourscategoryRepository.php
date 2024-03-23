<?php

namespace App\Repository;

use App\Entity\Courscategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Courscategory>
 *
 * @method Courscategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Courscategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Courscategory[]    findAll()
 * @method Courscategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourscategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Courscategory::class);
    }

//    /**
//     * @return Courscategory[] Returns an array of Courscategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Courscategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
