<?php


namespace App\Domain\Common;


abstract class Handler
{
    /**
     * Get called if the event from getEventClass occurs.
     */
    abstract public function handle($domainEvent): void;

    /**
     * Return the class name of the subscribed event.
     */
    abstract protected function getEventClass(): string;

    final public function canHandle($domainEvent): bool
    {
        return \get_class($domainEvent) === $this->getEventClass();
    }
}