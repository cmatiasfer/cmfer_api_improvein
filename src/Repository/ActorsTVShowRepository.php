<?php

namespace App\Repository;

use App\Entity\ActorsTVShow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActorsTVShow|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActorsTVShow|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActorsTVShow[]    findAll()
 * @method ActorsTVShow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActorsTVShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActorsTVShow::class);
    }

    // /**
    //  * @return ActorsTVShow[] Returns an array of ActorsTVShow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActorsTVShow
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
