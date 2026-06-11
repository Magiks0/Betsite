<?php

namespace App\Service;

use App\Entity\Bet;
use App\Entity\Event;
use App\Entity\Outcome;
use App\Entity\User;
use App\Enum\BetStatusEnum;
use App\Repository\EventRepository;
use App\Repository\OutcomeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class BettingService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly OddsCalculatorService $oddsCalculatorService,
        private readonly OutcomeRepository $outcomeRepository,
    ){

    }

    public function placeBet(User $user, Event $event, int $outcome, float $amount): bool
    {
        $outcome = $this->outcomeRepository->find($outcome);

        $bet = new Bet()
            ->setAuthor($user)
            ->setEvent($event)
            ->setEnding($outcome)
            ->setAmount($amount)
            ->setDate(new \DateTime())
            ->setStatus(BetStatusEnum::Waiting);

        $user->setBalance($user->getBalance() - $amount);

        $this->oddsCalculatorService->recalculateOdds($event, $outcome);

        $this->entityManager->persist($bet);

        $this->entityManager->flush();

        return true;
    }
}
