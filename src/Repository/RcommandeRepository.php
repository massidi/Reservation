<?php

namespace App\Repository;

use App\Entity\Rcommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rcommande>
 *
 * @method Rcommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rcommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rcommande[]    findAll()
 * @method Rcommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RcommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rcommande::class);
    }

//    /**
//     * @return Rcommande[] Returns an array of Rcommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Rcommande
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
