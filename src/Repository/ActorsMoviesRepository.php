<?php

namespace App\Repository;

use App\Entity\ActorsMovies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActorsMovies|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActorsMovies|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActorsMovies[]    findAll()
 * @method ActorsMovies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActorsMoviesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActorsMovies::class);
    }

    // /**
    //  * @return ActorsMovies[] Returns an array of ActorsMovies objects
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
    public function findOneBySomeField($value): ?ActorsMovies
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
