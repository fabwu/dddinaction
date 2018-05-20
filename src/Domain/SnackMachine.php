<?php


namespace App\Domain;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/** @ORM\Entity */
class SnackMachine extends AggregateRoot
{
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $moneyInTransaction;
    /**
     * @var Money
     * @ORM\Embedded(class="Money")
     */
    private $moneyInside;

    /**
     * @var Slot[] | ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Domain\Slot", mappedBy="snackMachine")
     */
    private $slots;

    public function __construct()
    {
        $this->moneyInTransaction = 0;
        $this->moneyInside        = Money::None();
        $this->slots              = new ArrayCollection([
            new Slot($this, 1),
            new Slot($this, 2),
            new Slot($this, 3),
        ]);
    }

    public function insertMoney(Money $money): void
    {
        if (
            Money::Cent()->isNotEquals($money) &&
            Money::TenCent()->isNotEquals($money) &&
            Money::Quarter()->isNotEquals($money) &&
            Money::Dollar()->isNotEquals($money) &&
            Money::FiveDollar()->isNotEquals($money) &&
            Money::TwentyDollar()->isNotEquals($money)
        ) {
            throw new LogicException('You can only insert one coin at a time');
        }

        $this->moneyInTransaction += $money->getAmount();
        $this->moneyInside        = $this->moneyInside->add($money);
    }

    public function returnMoney(): Money
    {
        $moneyToReturn            = $this->moneyInside->allocate($this->moneyInTransaction);
        $this->moneyInside        = $this->moneyInside->sub($moneyToReturn);
        $this->moneyInTransaction = 0;

        return $moneyToReturn;
    }

    public function buySnack(int $position): void
    {
        $slot = $this->getSlot($position);

        if ($slot->getSnackPile()->getPrice() > $this->moneyInTransaction) {
            throw new InvalidOperationException('Not enough money in transaction');
        }

        $slot->setSnackPile($slot->getSnackPile()->subtractOne());

        $changeAmount = $this->moneyInTransaction - $slot->getSnackPile()->getPrice();
        $change       = $this->moneyInside->allocate($changeAmount);

        if ($change->getAmount() < $changeAmount) {
            throw new InvalidOperationException('Not enough change inside the snack machine');
        }

        $this->moneyInTransaction = 0;

        $this->moneyInside = $this->moneyInside->sub($change);
    }

    public function getMoneyInTransaction(): float
    {
        return $this->moneyInTransaction;
    }

    public function getMoneyInside(): Money
    {
        return $this->moneyInside;
    }

    public function getSnackPile(int $position): SnackPile
    {
        return $this->getSlot($position)->getSnackPile();
    }

    public function getAllSnackPiles(): array
    {
        return $this->slots
            ->map(function (Slot $slot) {
                return $slot->getSnackPile();
            })
            ->getValues();
    }

    public function loadSnack(int $position, SnackPile $snackPile): void
    {
        $slot = $this->getSlot($position);
        $slot->setSnackPile($snackPile);
    }

    public function loadMoney(Money $money): void
    {
        $this->moneyInside = $this->moneyInside->add($money);
    }

    private function getSlot(int $position): Slot
    {
        return $this->slots
            ->filter(function (Slot $slot) use ($position) {
                return $slot->getPosition() === $position;
            })
            ->first();
    }
}