<?php


namespace App\Game\Model\Location;


abstract class Location
{
    const SIZE = 40;

    /** @var array $startCoordinates */
    protected $startCoordinates;

    /** @var string $name */
    protected $name;

    /**
     * Location constructor.
     * @param array $startCoordinates
     */
    public function __construct(array $startCoordinates, $name)
    {
        if (empty($startCoordinates)) {
            $startCoordinates = array(0, 0);
        }
        $this->startCoordinates = $startCoordinates;
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getStartCoordinates(): array
    {
        return $this->startCoordinates;
    }

    /**
     * @param array $startCoordinates
     */
    public function setStartCoordinates(array $startCoordinates): void
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