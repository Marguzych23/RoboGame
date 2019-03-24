<?php


namespace App\Game\Model;


use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\Weapon\Weapon;

class Robot
{
    /** @var Health $health */
    protected $health;

    /** @var Weapon[] $weapons */
    protected $weapons;

    /** @var Armor $armor */
    protected $armor;

    /**
     * Robot constructor.
     * @param Health|null $health
     * @param array $weapons
     * @param Armor|null $armor
     */
    public function __construct(Health $health = null, array $weapons = array(), Armor $armor = null)
    {
        if (is_null($health)) {
            $health = new Health();
        }
        if (is_null($armor)) {
            $armor = new Armor();
        }
        $this->health = $health;
        $this->weapons = $weapons;
        $this->armor = $armor;
    }

    /**
     * @return Health
     */
    public function getHealth(): Health
    {
        return $this->health;
    }

    /**
     * @param Health $health
     */
    public function setHealth(Health $health): void
    {
        $this->health = $health;
    }

    /**
     * @return Weapon[]
     */
    public function getWeapons(): array
    {
        return $this->weapons;
    }

    /**
     * @param Weapon[] $weapons
     */
    public function setWeapons(array $weapons): void
    {
        $this->weapons = $weapons;
    }

    /**
     * @return Armor
     */
    public function getArmor(): Armor
    {
        return $this->armor;
    }

    /**
     * @param Armor $armor
     */
    public function setArmor(Armor $armor): void
    {
        $this->armor = $armor;
    }
}