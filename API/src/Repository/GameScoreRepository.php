<?php

namespace App\Repository;

use App\Entity\GameScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameScore[]    findAll()
 * @method GameScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameScore::class);
    }

//    /**
//     * @return GameScore[] Returns an array of GameScore objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameScore
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
