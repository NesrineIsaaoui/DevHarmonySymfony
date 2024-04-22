<?php

namespace App\Repository;

use App\Entity\Categoriecodepromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoriecodepromo>
 *
 * @method |null find($id, $lockMode = null, $lockVersion = null)
 * @method |null findOneBy(array $criteria, array $orderBy = null)
 * @method []    findAll()
 * @method []    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriecodepromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoriecodepromo::class);
    }

    public function save(Categoriecodepromo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categoriecodepromo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
 





  

}
