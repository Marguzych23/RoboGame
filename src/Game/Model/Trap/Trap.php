<?php


namespace App\Game\Model\Trap;

use App\Game\Model\Coordinates;

abstract class Trap
{
    /** @var int $actionTime */
    protected $actionTime;

    /** @var string $name */
    protected $name;
    /** @var Coordinates $coordinates */
    protected $coordinates;

    /**
     * InteractionObject constructor.
     * @param Coordinates $coordinates
     * @param string $name
     * @param int $actionTime
     */
    public function __construct(Coordinates $coordinates, string $name, int $actionTime)
    {
        $this->coordinates = $coordinates;
        $this->name = $name;
        $this->actionTime = $actionTime;
    }

    /**
     * @return int
     */
    public function getActionTime(): int
    {
        return $this->actionTime;
    }

    /**
     * @param int $actionTime
     */
    public function setActionTime(int $actionTime): void
    {
        $this->actionTime = $actionTime;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function jsonSerialize()
    {
        return array(
            'name' => $this->name,
            'coordinates' => $this->coordinates,
            'actionTime' => $this->actionTime,
        );
    }
}