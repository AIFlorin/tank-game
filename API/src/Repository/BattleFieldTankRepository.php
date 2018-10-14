<?php

namespace App\Repository;

use App\Entity\BattleFieldTank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BattleFieldTank|null find($id, $lockMode = null, $lockVersion = null)
 * @method BattleFieldTank|null findOneBy(array $criteria, array $orderBy = null)
 * @method BattleFieldTank[]    findAll()
 * @method BattleFieldTank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BattleFieldTankRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BattleFieldTank::class);
    }

//    /**
//     * @return BattleFieldTank[] Returns an array of BattleFieldTank objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BattleFieldTank
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
