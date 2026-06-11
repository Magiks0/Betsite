<?php

namespace App\DataFixtures;

use App\Entity\Bet;
use App\Entity\Outcome;
use App\Entity\User;
use App\Enum\BetStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Ton enum BetStatusEnum devrait contenir : EN_ATTENTE, GAGNE, PERDU, ANNULE
        $statuses = BetStatusEnum::cases();

        for ($i = 1; $i <= 30; $i++) {
            $bet = new Bet();

            // 1. Auteur (Parieur)
            /** @var User $author */
            $author = $this->getReference('user_' . rand(1, 5), User::class);
            $bet->setAuthor($author);

            // 2. Issue choisie (il y a environ 28 issues générées selon le code précédent)
            /** @var Outcome $outcome */
            $randomOutcomeId = rand(1, 28);
            if ($this->hasReference('outcome_' . $randomOutcomeId, Outcome::class)) {
                $outcome = $this->getReference('outcome_' . $randomOutcomeId, Outcome::class);
                $bet->setEnding($outcome);

                // L'événement se déduit de l'issue
                $bet->setEvent($outcome->getEvent());
            }

            // 3. Montant du pari
            $bet->setAmount(rand(10, 100));

            // 4. Date du pari
            $bet->setDate((new \DateTime()));

            // 5. Statut
            $bet->setStatus($statuses[array_rand($statuses)]);

            $manager->persist($bet);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            OutcomeFixtures::class,
        ];
    }
}
