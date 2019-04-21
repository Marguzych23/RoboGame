<?php


namespace App\Game\Service;


use App\Game\Model\Coordinates;

class CoordinatesService
{
    /** @var Coordinates[] $occupiedCoordinates */
    protected $occupiedCoordinates = array();

    /**
     * @return Coordinates[]
     */
    public function getOccupiedCoordinates(): array
    {
        return $this->occupiedCoordinates;
    }

    /**
     * @param Coordinates $occupiedCoordinates
     */
    public function setOccupiedCoordinates(Coordinates $occupiedCoordinates): void
    {
        array_push($this->occupiedCoordinates, $occupiedCoordinates);
    }
}