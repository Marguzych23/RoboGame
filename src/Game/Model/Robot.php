<?php


namespace App\Game\Model;


use App\Game\Model\InteractionObject\Armor\Armor;
use App\Game\Model\Trap\Trap;
use App\Game\Model\InteractionObject\Weapon\Weapon;
use App\Game\Model\Location\Location;

class Robot implements \JsonSerializable
{
    /** @var string $authorNickName */
    protected $authorNickName;

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

    /** @var Coordinates $coordinates */
    protected $coordinates;

    /** @var Location $location */
    protected $location;

    /**
     * Robot constructor.
     * @param string $authorNickName
     * @param Script $script
     * @param Coordinates $coordinates
     * @param Health|null $health
     * @param array $weapons
     * @param Armor|null $armor
     * @param Location|null $location
     * @param Trap|null $trap
     */
    public function __construct(string $authorNickName, Script $script, Coordinates $coordinates, Health $health = null, array $weapons = array(), Armor $armor = null, Location $location = null, Trap $trap = null)
    {
        if (is_null($health)) {
            $health = new Health();
        }
        if (empty($coordinates)) {
            $coordinates = new Coordinates(0, 0);
        }
        if (is_null($armor)) {
            $armor = new Armor($coordinates);
        }
        $this->authorNickName = $authorNickName;
        $this->script = $script;
        $this->coordinates = $coordinates;
        $this->health = $health;
        $this->weapons = $weapons;
        $this->armor = $armor;
        if (!is_null($location)) {
            $this->location = $location;
        }
        if (!is_null($trap)) {
            $this->trap = $trap;
        }
    }

    /**
     * @return string
     */
    public function getAuthorNickName(): string
    {
        return $this->authorNickName;
    }

    /**
     * @param string $authorNickName
     */
    public function setAuthorNickName(string $authorNickName): void
    {
        $this->authorNickName = $authorNickName;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinates $coordinates
     */
    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
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
    public function getTrap()
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
    public function setLocation(Location $location = null): void
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'authorNickName' => $this->authorNickName,
            'coordinates' => $this->coordinates,
            'script' => $this->script,
            'location' => $this->location,
            'trap' => $this->trap,
            'weapons' => $this->weapons,
            'armor' => $this->armor,
            'health' => $this->health,
        );
    }
}