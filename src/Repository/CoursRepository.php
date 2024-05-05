<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 *
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }
    public function searchByTerm($searchTerm)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.coursname LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }
    public function findAllSorted(): array
    {
        $queryBuilder = $this->createQueryBuilder('cl')
            ->orderBy('cl.coursprix', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
    public function findAllSorted1(): array
    {
        $queryBuilder = $this->createQueryBuilder('cl')
            ->orderBy('cl.coursprix', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }
    
    public function save(Cours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
 
    public function searchByName($searchQuery)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('c.coursname', ':searchQuery'),
                $queryBuilder->expr()->like('c.coursprix', ':searchQuery'),
                $queryBuilder->expr()->like('c.coursdescription', ':searchQuery')
            ))

                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }
        return $queryBuilder->getQuery()->getResult();
    }

//    /**
//     * @return Cours[] Returns an array of Cours objects
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

//    public function findOneBySomeField($value): ?Cours
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
