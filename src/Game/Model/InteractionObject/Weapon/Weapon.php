<?php


namespace App\Game\Model\InteractionObject\Weapon;


use App\Game\Model\InteractionObject\InteractionObject;

abstract class Weapon implements InteractionObject
{
    /** @var string $name */
    protected $name;
    /** @var int $value */
    protected $value;

    /**
     * @return int
     */
    public function getWeaponDamage(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getWeaponName(): string
    {
        return $this->name;
    }

    /**
     * @param int $value
     */
    protected function setWeaponDamage(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @param string $name
     */
    protected function setWeaponName(string $name): void
    {
        $this->name = $name;
    }

}