<?php

namespace App\Service;

use App\Repository\EventRepository;

class EventService
{
    public function __construct(private EventRepository $eventRepository){}

    public function getAllEvents(): array
    {
        return $this->eventRepository->findAll();
    }
}
