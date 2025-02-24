<?php

namespace App\Repository;

use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    public function searchByCriteria($villeDepartId, $villeArriveeId, $dateDepart)
    {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.villeDepart = :depart')
            ->andWhere('t.villeArrivee = :arrivee')
            ->andWhere('t.dateHeure = :date')
            ->setParameter('depart', $villeDepartId)
            ->setParameter('arrivee', $villeArriveeId)
            ->setParameter('date', new \DateTime($dateDepart));

        return $qb->getQuery()->getResult();
    }
}
