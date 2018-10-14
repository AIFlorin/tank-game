<?php

namespace App\Repository;

use App\Entity\BattleField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BattleField|null find($id, $lockMode = null, $lockVersion = null)
 * @method BattleField|null findOneBy(array $criteria, array $orderBy = null)
 * @method BattleField[]    findAll()
 * @method BattleField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BattleFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BattleField::class);
    }

//    /**
//     * @return BattleField[] Returns an array of BattleField objects
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
    public function findOneBySomeField($value): ?BattleField
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
