<?php

namespace App\Entity;

use App\Repository\SubscriptionHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionHistoryRepository::class)]
class SubscriptionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToOne(mappedBy: 'subscriptionHistory', cascade: ['persist', 'remove'])]
    private ?Subscription $subscription = null;

    #[ORM\OneToOne(mappedBy: 'subscriptionHistory', cascade: ['persist', 'remove'])]
    private ?User $subscriber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): static
    {
        // unset the owning side of the relation if necessary
        if ($subscription === null && $this->subscription !== null) {
            $this->subscription->setSubscriptionHistory(null);
        }

        // set the owning side of the relation if necessary
        if ($subscription !== null && $subscription->getSubscriptionHistory() !== $this) {
            $subscription->setSubscriptionHistory($this);
        }

        $this->subscription = $subscription;

        return $this;
    }

    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    public function setSubscriber(?User $subscriber): static
    {
        // unset the owning side of the relation if necessary
        if ($subscriber === null && $this->subscriber !== null) {
            $this->subscriber->setSubscriptionHistory(null);
        }

        // set the owning side of the relation if necessary
        if ($subscriber !== null && $subscriber->getSubscriptionHistory() !== $this) {
            $subscriber->setSubscriptionHistory($this);
        }

        $this->subscriber = $subscriber;

        return $this;
    }
}
