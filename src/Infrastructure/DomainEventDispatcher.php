<?php


namespace App\Infrastructure;


use App\Domain\Common\AggregateRoot;
use App\Domain\Common\Handler;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;

class DomainEventDispatcher implements EventSubscriber
{
    /** @var AggregateRoot[] */
    private $entities;

    /** @var Handler[] */
    private $handlers;

    /**
     * A compiler pass adds all services with the app.domain_event_handler tag.
     */
    public function addHandler(Handler $handler): void
    {
        $this->handlers[] = $handler;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'postPersist',
            'postUpdate',
            'postRemove',
            'postFlush',
        ];
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $this->keepAggregateRoots($event);
    }

    public function postUpdate(LifecycleEventArgs $event): void
    {
        $this->keepAggregateRoots($event);
    }

    public function postRemove(LifecycleEventArgs $event): void
    {
        $this->keepAggregateRoots($event);
    }

    public function postFlush(PostFlushEventArgs $flushEvent): void
    {
        foreach ($this->entities as $entity) {
            $events = $entity->popEvents();

            foreach ($events as $event) {
                foreach ($this->handlers as $handler) {
                    if ($handler->canHandle($event)) {
                        $handler->handle($event);
                    }
                }
            }
        }

        $this->entities = [];
    }

    private function keepAggregateRoots(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ( ! ($entity instanceof AggregateRoot)) {
            return;
        }

        $this->entities[] = $entity;
    }
}