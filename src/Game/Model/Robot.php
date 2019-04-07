<?php


namespace App\Game\Model;


use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\InteractionObject\Trap\Trap;
use App\Game\Model\InteractionObject\Weapon\Weapon;
use App\Game\Model\Location\Location;

class Robot
{
    /** @var Script $script */
    protected $script;

    /** @var Health $health */
    protected $health;

    /** @var Weapon[] $weapons */
    protected $weapons;

    /** @var Armor $armor */
    protected $armor;

    /** @var Trap $trap */
    protected $trap;

    /** @var array $coordinates */
    protected $coordinates;

    /** @var Location $location */
    protected $location;

    /**
     * Robot constructor.
     * @param Script $script
     * @param array $coordinates
     * @param Health|null $health
     * @param array $weapons
     * @param Armor|null $armor
     */
    public function __construct(Script $script, array $coordinates, Health $health = null, array $weapons = array(), Armor $armor = null)
    {
        if (is_null($health)) {
            $health = new Health();
        }
        if (empty($coordinates)) {
            $coordinates = array(0, 0);
        }
        if (is_null($armor)) {
            $armor = new Armor(null);
        }
        $this->script = $script;
        $this->coordinates = $coordinates;
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

    /**
     * @return Trap
     */
    public function getTrap(): Trap
    {
        return $this->trap;
    }

    /**
     * @param Trap $trap
     */
    public function setTrap(Trap $trap): void
    {
        $this->trap = $trap;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    /**
     * @return Script
     */
    public function getScript(): Script
    {
        return $this->script;
    }

    /**
     * @param Script $script
     */
    public function setScript(Script $script): void
    {
        $this->script = $script;
    }
}