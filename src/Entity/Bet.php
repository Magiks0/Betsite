<?php

namespace App\Entity;

use App\Enum\BetStatusEnum;
use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BetRepository::class)]
class Bet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    private ?Outcome $outcome = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    private ?float $amount = null;

    #[ORM\Column]
    private ?float $odd = 1.50;

    #[ORM\Column(length: 255)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?BetStatusEnum $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getOutcome(): ?Outcome
    {
        return $this->outcome;
    }

    public function setEnding(?Outcome $outcome): static
    {
        $this->outcome = $outcome;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getOdd(): ?float
    {
        return $this->odd;
    }

    public function setOdd(?float $odd): static
    {
        $this->odd = $odd;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?BetStatusEnum
    {
        return $this->status;
    }

    public function setStatus(BetStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }
}
