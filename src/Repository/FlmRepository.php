<?php

namespace App\Repository;

use App\Entity\Flm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flm>
 *
 * @method Flm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flm[]    findAll()
 * @method Flm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flm::class);
    }

//    /**
//     * @return Flm[] Returns an array of Flm objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Flm
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
