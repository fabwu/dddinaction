<?php


namespace App\Domain\Common;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function isEquals($other): bool
    {
        if ($other === null) {
            return false;
        }

        if ($this === $other) {
            return true;
        }

        if ( ! $other instanceof self) {
            return false;
        }

        if ($this->id === null || $other->id === null) {
            return false;
        }

        return $this->id === $other->id;
    }

    public function isNotEquals($other): bool
    {
        return ! $this->isEquals($other);
    }
}