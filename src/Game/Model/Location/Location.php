<?php


namespace App\Game\Model\Location;


use App\Game\Model\Coordinates;

abstract class Location implements \JsonSerializable
{
    const SIZE = 40;

    /** @var Coordinates $startCoordinates */
    protected $startCoordinates;

    /** @var string $name */
    protected $name;

    /** @var int $size */
    protected $size;

    /**
     * Location constructor.
     * @param Coordinates $startCoordinates
     * @param string $name
     * @param int $size
     */
    public function __construct(Coordinates $startCoordinates, string $name, int $size = self::SIZE)
    {
        $this->startCoordinates = $startCoordinates;
        $this->name = $name;
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
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

    public function jsonSerialize()
    {
        return array(
            'name' => $this->name,
            'startCoordinates' => $this->startCoordinates,
            'size' => $this->size,
        );
    }
}