<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){

    }
    public function updateBalance(User $user, string $amount): void
    {
        $user->setBalance($user->getBalance() + $amount);
        $this->entityManager->flush();
    }
}
