<?php

namespace App\DataFixtures;

use App\Entity\Endings;
use App\Entity\Event;
use App\Entity\Outcome;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OutcomeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $endingCounter = 1;

        for ($i = 1; $i <= 10; $i++) {
            /** @var Event $event */
            $event = $this->getReference('event_' . $i, Event::class);

            $labels = ['Victoire Équipe 1', 'Match Nul', 'Victoire Équipe 2'];

            if ($event->getSport() === 'Tennis') {
                $labels = ['Victoire Joueur 1', 'Victoire Joueur 2'];
            }

            foreach ($labels as $label) {
                $ending = new Outcome();
                $ending->setLabel($label)
                    ->setEvent($event);

                $manager->persist($ending);
                $this->addReference('outcome_' . $endingCounter, $ending);
                $endingCounter++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
        ];
    }
}
