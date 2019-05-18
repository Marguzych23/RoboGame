<?php


namespace App\Game\DTO;


class LocationDTO implements \JsonSerializable
{
    /** @var CoordinatesDTO $startCoordinates */
    public $startCoordinates;
    /** @var string $name */
    public $name;
    /** @var int $size */
    public $size;
    /** @var CoordinatesDTO $endCoordinates */
    public $endCoordinates;

    /**
     * LocationDTO constructor.
     * @param CoordinatesDTO $startCoordinates
     * @param string $name
     * @param int $size
     * @param CoordinatesDTO|null $endCoordinates
     */
    public function __construct(CoordinatesDTO $startCoordinates, string $name, int $size, CoordinatesDTO $endCoordinates = null)
    {
        $this->startCoordinates = $startCoordinates;
        $this->name = $name;
        $this->size = $size;
        $this->endCoordinates = $endCoordinates;
    }

    /**
     * @return CoordinatesDTO
     */
    public function getEndCoordinates(): CoordinatesDTO
    {
        return $this->endCoordinates;
    }

    /**
     * @param CoordinatesDTO $endCoordinates
     */
    public function setEndCoordinates(CoordinatesDTO $endCoordinates): void
    {
        $this->endCoordinates = $endCoordinates;
    }

    /**
     * @return CoordinatesDTO
     */
    public function getStartCoordinates(): CoordinatesDTO
    {
        return $this->startCoordinates;
    }

    /**
     * @param CoordinatesDTO $startCoordinates
     */
    public function setStartCoordinates(CoordinatesDTO $startCoordinates): void
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
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'startCoordinates' => $this->startCoordinates,
            'name' => $this->name,
            'size' => $this->size,
            'endCoordinates' => $this->endCoordinates,
        );
    }
}