<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function findAllRoles(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.nomRole', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findRoleByName(string $name): ?Role
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.nomRole = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
