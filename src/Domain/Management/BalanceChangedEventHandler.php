<?php


namespace App\Domain\Management;


use App\Domain\Atm\BalanceChangedEvent;
use App\Domain\Common\Handler;

class BalanceChangedEventHandler extends Handler
{
    private $repository;

    public function __construct(HeadOfficeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BalanceChangedEvent $domainEvent
     */
    public function handle($domainEvent): void
    {
        $headOffice = $this->repository->instance();
        $headOffice->changeBalance($domainEvent->getDelta());
        $this->repository->save($headOffice);
    }

    protected function getEventClass(): string
    {
        return BalanceChangedEvent::class;
    }
}