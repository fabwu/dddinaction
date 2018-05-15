<?php


namespace App\Domain;


use Doctrine\ORM\Mapping as ORM;
use LogicException;

/** @ORM\Embeddable */
class Money extends ValueObject
{
    /** @ORM\Column(type="integer") */
    private $oneCentCount;

    /** @ORM\Column(type="integer") */
    private $tenCentCount;

    /** @ORM\Column(type="integer") */
    private $quarterCount;

    /** @ORM\Column(type="integer") */
    private $oneDollarCount;

    /** @ORM\Column(type="integer") */
    private $fiveDollarCount;

    /** @ORM\Column(type="integer") */
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

    public static function TwentyDollar(): Money
    {
        return new Money(0, 0, 0, 0, 0, 1);
    }

    public static function FiveDollar(): Money
    {
        return new Money(0, 0, 0, 0, 1, 0);
    }

    public static function Dollar(): Money
    {
        return new Money(0, 0, 0, 1, 0, 0);
    }

    public static function Quarter(): Money
    {
        return new Money(0, 0, 1, 0, 0, 0);
    }

    public static function TenCent(): Money
    {
        return new Money(0, 1, 0, 0, 0, 0);
    }

    public static function Cent(): Money
    {
        return new Money(1, 0, 0, 0, 0, 0);
    }

    public static function None(): Money
    {
        return new Money(0, 0, 0, 0, 0, 0);
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

    public function sub(Money $m): Money
    {
        return new Money(
            $this->oneCentCount - $m->oneCentCount,
            $this->tenCentCount - $m->tenCentCount,
            $this->quarterCount - $m->quarterCount,
            $this->oneDollarCount - $m->oneDollarCount,
            $this->fiveDollarCount - $m->fiveDollarCount,
            $this->twentyDollarCount - $m->twentyDollarCount
        );
    }

    public function multiply(int $multiplier): Money
    {
        return new Money(
            $this->oneCentCount * $multiplier,
            $this->tenCentCount * $multiplier,
            $this->quarterCount * $multiplier,
            $this->oneDollarCount * $multiplier,
            $this->fiveDollarCount * $multiplier,
            $this->twentyDollarCount * $multiplier
        );
    }

    public function getAmount()
    {
        return
            0.01 * $this->oneCentCount +
            0.1 * $this->tenCentCount +
            0.25 * $this->quarterCount +
            1 * $this->oneDollarCount +
            5 * $this->fiveDollarCount +
            20 * $this->twentyDollarCount;
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

    public function isEquals($obj): bool
    {
        return
            $obj instanceof self &&
            $this->oneCentCount === $obj->oneCentCount &&
            $this->tenCentCount === $obj->tenCentCount &&
            $this->quarterCount === $obj->quarterCount &&
            $this->oneDollarCount === $obj->oneDollarCount &&
            $this->fiveDollarCount === $obj->fiveDollarCount &&
            $this->twentyDollarCount === $obj->twentyDollarCount;
    }

    public function __toString()
    {
        $amount = $this->getAmount();

        if ($amount < 1) {
            return '¢ ' . $amount * 100;
        }

        return '$ ' . sprintf('%01.2f', $amount);
    }

    public function allocate(float $amount): Money
    {
        $twentyDollarCount = min((int)($amount / 20), $this->twentyDollarCount);
        $amount            -= $twentyDollarCount * 20;

        $fiveDollarCount = min((int)($amount / 5), $this->fiveDollarCount);
        $amount          -= $fiveDollarCount * 5;

        $oneDollarCount = min((int)$amount, $this->oneDollarCount);
        $amount         -= $oneDollarCount;

        $quarterCount = min((int)($amount / 0.25), $this->quarterCount);
        $amount       -= $quarterCount * 0.25;

        $tenCentCount = min((int)($amount / 0.1), $this->tenCentCount);
        $amount       -= $tenCentCount * 0.1;

        $oneCentCount = min($amount / 0.01, $this->oneCentCount);

        return new Money(
            $oneCentCount,
            $tenCentCount,
            $quarterCount,
            $oneDollarCount,
            $fiveDollarCount,
            $twentyDollarCount);
    }
}