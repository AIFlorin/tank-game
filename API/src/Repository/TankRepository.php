<?php

namespace App\Repository;

use App\Entity\Tank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tank|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tank|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tank[]    findAll()
 * @method Tank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TankRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tank::class);
    }

    public function getOtherTank(Tank $tank): Tank
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->where('t <> :tank')
            ->setParameter(':tank', $tank);

        $tank =  $queryBuilder->getQuery()->setMaxResults(1)->getResult();

        return $tank[0];
    }
}
