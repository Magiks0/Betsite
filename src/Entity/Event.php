<?php

namespace App\Entity;

use App\Enum\EventStatusEnum;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $sport = null;

    #[ORM\Column(length: 255)]
    private ?string $competitors = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(enumType: EventStatusEnum::class)]
    private ?EventStatusEnum $status = null;

    /**
     * @var Collection<int, Outcome>
     */
    #[ORM\OneToMany(targetEntity: Outcome::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $outcomes;

    /**
     * @var Collection<int, Bet>
     */
    #[ORM\OneToMany(targetEntity: Bet::class, mappedBy: 'event')]
    private Collection $bets;

    public function __construct()
    {
        $this->outcomes = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(string $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    public function getCompetitors(): ?string
    {
        return $this->competitors;
    }

    public function setCompetitors(string $competitors): static
    {
        $this->competitors = $competitors;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?EventStatusEnum
    {
        return $this->status;
    }

    public function setStatus(EventStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Endings>
     */
    public function getOutcomes(): Collection
    {
        return $this->outcomes;
    }

    public function addOutcome(Outcome $outcome): static
    {
        if (!$this->outcomes->contains($outcome)) {
            $this->outcomes->add($outcome);
            $outcome->setEvent($this);
        }

        return $this;
    }

    public function removeOutcome(Outcome $outcome): static
    {
        if ($this->outcomes->removeElement($outcome)) {
            // set the owning side to null (unless already changed)
            if ($outcome->getEvent() === $this) {
                $outcome->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bet>
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): static
    {
        if (!$this->bets->contains($bet)) {
            $this->bets->add($bet);
            $bet->setEvent($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getEvent() === $this) {
                $bet->setEvent(null);
            }
        }

        return $this;
    }
}
