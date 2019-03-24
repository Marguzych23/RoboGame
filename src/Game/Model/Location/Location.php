<?php


namespace App\Game\Model\Location;


use App\Game\Model\Coordinates;

abstract class Location
{
    const SIZE = 40;

    /** @var Coordinates $startCoordinates */
    protected $startCoordinates;

    /** @var string $name */
    protected $name;

    /**
     * Location constructor.
     * @param Coordinates $startCoordinates
     * @param string $name
     */
    public function __construct(Coordinates $startCoordinates, string $name)
    {
        $this->startCoordinates = $startCoordinates;
        $this->name = $name;
    }

    /**
     * @return Coordinates
     */
    public function getStartCoordinates(): Coordinates
    {
        return $this->startCoordinates;
    }

    /**
     * @param Coordinates $startCoordinates
     */
    public function setStartCoordinates(Coordinates $startCoordinates): void
    {
        $this->startCoordinates = $startCoordinates;
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

}