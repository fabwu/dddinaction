<?php


namespace App\Domain\Common;


class AggregateRoot extends Entity
{
    /** @var DomainEvent[] */
    private $domainEvents = [];

    /**
     * @return DomainEvent[]
     */
    public function popEvents(): array
    {
        $events             = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }

    public function raise(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}