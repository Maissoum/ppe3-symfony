<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avis>
 *
 * @method Avis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avis[]    findAll()
 * @method Avis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    /**
     * Filtre les avis en fonction du titre du film et de la note minimale
     *
     * @param string|null $film Le titre (partiel) du film
     * @param int|null $note Note minimale
     * @return Avis[]
     */
    public function findByFilmAndNote(?string $film, ?int $note): array
    {
        $qb = $this->createQueryBuilder('a')
                   ->join('a.flms', 'f'); // 'f' est le film lié à l'avis

        if (!empty($film)) {
            $qb->andWhere('f.titre LIKE :film')
               ->setParameter('film', '%' . $film . '%');
        }

        if (!empty($note)) {
            $qb->andWhere('a.note >= :note')
               ->setParameter('note', $note);
        }

        return $qb
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
