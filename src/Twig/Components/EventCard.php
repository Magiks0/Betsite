<?php

namespace App\Twig\Components;

use App\Entity\Event;
use App\Form\BetType;
use App\Repository\EventRepository;
use App\Service\BettingService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('EventCard')]
class EventCard
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public function __construct(
        private EventRepository $eventRepository,
        private FormFactoryInterface $formFactory,
    ) {}

    #[LiveProp]
    public int $eventId;

    #[LiveProp]
    public bool $isBetFormOpen = false;

    #[LiveProp]
    public float $odd = 0.0;

    #[LiveProp(writable: true)]
    public float $amount = 0.0;

    #[LiveProp]
    public ?int $selectedOutcomeId = null;

    #[LiveProp]
    public string $selectedLabel = '';

    public function mount(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function getEvent(): Event
    {
        return $this->eventRepository->find($this->eventId);
    }

    public function getPotentialWins(): float
    {
        return $this->amount * $this->odd;
    }

    #[LiveAction]
    public function openBetForm(
        #[LiveArg] int $id,
        #[LiveArg] float $odd,
        #[LiveArg] string $label
    ): void {
        $this->selectedOutcomeId = $id;
        $this->odd = $odd;
        $this->selectedLabel = $label;
        $this->isBetFormOpen = true;
    }

    #[LiveAction]
    public function closeForm(): void
    {
        $this->selectedOutcomeId = null;
        $this->isBetFormOpen = false;
        $this->amount = 0.0;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->formFactory->create(BetType::class, null, []);
    }

    #[LiveAction]
    public function saveBet(BettingService $bettingService, Security $security): null|RedirectResponse
    {
        try {
            $this->submitForm();

            $form = $this->getForm();
            if (!$form->isValid()) {
                return null;
            }

            $user = $security->getUser();
            if (!$user) {
                return new RedirectResponse('/login');
            }

            $amount = $this->amount;

            $bettingService->placeBet($user, $this->getEvent(), $this->selectedOutcomeId, $amount);

            $this->isBetFormOpen = false;
            $this->amount = 0.0;

            return new RedirectResponse('/');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
