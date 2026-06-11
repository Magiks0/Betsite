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

        if ($newOdd < 1.10) {
            $newOdd = 1.10;
        } elseif ($newOdd > 5.00) {
            $newOdd = 5.00;
        }

        $outcome->setCurrentOdd($newOdd);

        $this->entityManager->flush();
    }
}
