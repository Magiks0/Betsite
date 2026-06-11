<?php

namespace App\Repository;

use App\Entity\Bet;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bet>
 */
class BetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bet::class);
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.author = :user')
            ->setParameter('user', $user)
            ->orderBy('b.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
