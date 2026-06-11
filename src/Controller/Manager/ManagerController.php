<?php

namespace App\Controller\Manager;

use App\Form\EventType;
use App\Service\EventService;
use App\Service\SportEventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/manager', name: 'manager_')]
#[IsGranted('ROLE_MANAGER')]
class ManagerController extends AbstractController
{
    #[Route('/events', name: 'events_index')]
    public function index(EventService $service): Response
    {
        return $this->render('manager/events/index.html.twig', [
            'events' => $service->getAllEvents(),
        ]);
    }

    #[Route('/events/create', name: 'events_create')]
    public function create(Request $request, SportEventService $service): Response
    {
        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->createEvent($form->getData());
            $this->addFlash('success', 'Événement créé !');
            return $this->redirectToRoute('manager_events_index');
        }

        return $this->render('manager/events/create.html.twig', ['form' => $form]);
    }
}
