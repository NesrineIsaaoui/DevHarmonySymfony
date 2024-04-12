<?php

namespace App\Repository;
use App\Entity\Avis;
use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avis>
 *
 * @method Avis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avis[]    findAll()
 * @method Avis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }
    public function getAverageRatingForCours(Cours $cours): ?float
    {
        return $this->createQueryBuilder('a')
            ->select('AVG(a.etoiles) as average_rating')
            ->andWhere('a.cours = :cours')
            ->setParameter('cours', $cours)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function getRatingsForCours(Cours $cours): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.etoiles')
            ->andWhere('a.cours = :cours')
            ->setParameter('cours', $cours)
            ->getQuery();

        $ratings = $qb->getResult();

        // Extract etoiles values from Avis objects
        $etoilesArray = array_map(function($avis) {
            return $avis['etoiles'];
        }, $ratings);

        return $etoilesArray;
    }

//    /**
//     * @return Avis[] Returns an array of Avis objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Avis
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}
