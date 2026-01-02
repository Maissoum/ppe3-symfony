<?php

namespace App\Repository;

use App\Entity\Cat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cat>
 *
 * @method Cat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cat[]    findAll()
 * @method Cat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cat::class);
    }

    /**
     * Recherche des catégories par nom (partiel)
     *
     * @param string|null $nom
     * @return Cat[]
     */
    public function findByNom(?string $nom): array
    {
        $qb = $this->createQueryBuilder('c');

        if (!empty($nom)) {
            $qb->andWhere('c.nom LIKE :nom')
               ->setParameter('nom', '%' . $nom . '%');
        }

        return $qb
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
