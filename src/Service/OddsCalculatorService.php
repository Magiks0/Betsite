<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Outcome;
use Doctrine\ORM\EntityManagerInterface;

final class OddsCalculatorService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){

    }
    public function recalculateOdds(Event $event, Outcome $outcome): void
    {
        $newOdd = count($event->getBets()) / count($outcome->getBets());
        $outcome->setCurrentOdd($newOdd);

        $this->entityManager->flush();
    }
}
