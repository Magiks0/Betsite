<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Enum\EventStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const REFERENCE_IDENTIFIER = 'event_';

    public function load(ObjectManager $manager): void
    {
        $matches = [
            ['name' => 'Quart de finale - Coupe du monde 2026', 'sport' => 'Football', 'participants' => 'France - Brésil'],
            ['name' => 'Demi finale - Coupe de France', 'sport' => 'Football', 'participants' => 'PSG - OM'],
            ['name' => 'Rolland Garros - Jour 3', 'sport' => 'Tennis', 'participants' => 'Nadal - Alcaraz'],
            ['name' => 'NBA', 'sport' => 'Basketball', 'participants' => 'Lakers - Bulls'],
            ['name' => 'Tournoi des 6 nations - Finale' ,'sport' => 'Rugby', 'participants' => 'France - Irlande'],
        ];

        $statuses = EventStatusEnum::cases();

        for ($i = 1; $i <= 10; $i++) {
            $event = new Event();

            $match = $matches[array_rand($matches)];
            $event->setName($match['name']);
            $event->setCompetitors($match['participants']);
            $event->setSport($match['sport']);

            $randomDays = random_int(-5, 15);
            $date = (new \DateTimeImmutable())->modify("$randomDays days");
            $event->setDate($date);

            $event->setStatus($statuses[array_rand($statuses)]);

            $manager->persist($event);
            $this->addReference(self::REFERENCE_IDENTIFIER . $i, $event);
        }

        $manager->flush();
    }
}
