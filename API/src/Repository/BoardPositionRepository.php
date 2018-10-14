<?php

namespace App\Repository;

use App\Entity\BoardPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BoardPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardPosition[]    findAll()
 * @method BoardPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardPositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BoardPosition::class);
    }

//    /**
//     * @return BoardPosition[] Returns an array of BoardPosition objects
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
    public function findOneBySomeField($value): ?BoardPosition
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
