<?php

namespace App\Repository;

use App\Entity\GameAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameAction[]    findAll()
 * @method GameAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameActionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameAction::class);
    }

//    /**
//     * @return GameAction[] Returns an array of GameAction objects
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
    public function findOneBySomeField($value): ?GameAction
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
