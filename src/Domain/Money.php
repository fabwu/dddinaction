<?php


namespace App\Domain;


use LogicException;

class Money
{
    private $oneCentCount;
    private $tenCentCount;
    private $quarterCount;
    private $oneDollarCount;
    private $fiveDollarCount;
    private $twentyDollarCount;

    public function __construct($oneCentCount, $tenCentCount, $quarterCount, $oneDollarCount, $fiveDollarCount, $twentyDollarCount)
    {
        if ($oneCentCount < 0 || $tenCentCount < 0 || $quarterCount < 0 || $oneDollarCount < 0 || $fiveDollarCount < 0 || $twentyDollarCount < 0) {
            throw new LogicException('Count cannot be negative');
        }

        $this->oneCentCount      = $oneCentCount;
        $this->tenCentCount      = $tenCentCount;
        $this->quarterCount      = $quarterCount;
        $this->oneDollarCount    = $oneDollarCount;
        $this->fiveDollarCount   = $fiveDollarCount;
        $this->twentyDollarCount = $twentyDollarCount;
    }

    public function add(Money $m): Money
    {
        return new Money(
            $this->oneCentCount + $m->oneCentCount,
            $this->tenCentCount + $m->tenCentCount,
            $this->quarterCount + $m->quarterCount,
            $this->oneDollarCount + $m->oneDollarCount,
            $this->fiveDollarCount + $m->fiveDollarCount,
            $this->twentyDollarCount + $m->twentyDollarCount
        );
    }

    public function getOneCentCount()
    {
        return $this->oneCentCount;
    }

    public function getTenCentCount()
    {
        return $this->tenCentCount;
    }

    public function getQuarterCount()
    {
        return $this->quarterCount;
    }

    public function getOneDollarCount()
    {
        return $this->oneDollarCount;
    }

    public function getFiveDollarCount()
    {
        return $this->fiveDollarCount;
    }

    public function getTwentyDollarCount()
    {
        return $this->twentyDollarCount;
    }
}