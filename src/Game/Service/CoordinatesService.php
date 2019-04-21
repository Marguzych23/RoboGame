<?php


namespace App\Game\Service;


use App\Game\Model\Coordinates;

class CoordinatesService
{
    /** @var Coordinates[] $occupiedCoordinates */
    protected $occupiedCoordinates;

    /**
     * CoordinatesService constructor.
     * @param Coordinates[] $occupiedCoordinates
     */
    public function __construct(array $occupiedCoordinates = array())
    {
        $this->occupiedCoordinates = $occupiedCoordinates;
    }

    /**
     * @return Coordinates[]
     */
    public function getOccupiedCoordinates(): array
    {
        return $this->occupiedCoordinates;
    }

    /**
     * @param Coordinates $locationCoordinates
     * @param int $locationSize
     * @return Coordinates
     */
    public function generateCoordinatesForInteractionObjects(Coordinates $locationCoordinates, int $locationSize): Coordinates
    {
        return $this->generateCoordinates(
            $locationCoordinates->getX(), $locationCoordinates->getX() + $locationSize - 1,
            $locationCoordinates->getY(), $locationCoordinates->getY() + $locationSize - 1
        );
    }

    /**
     * @param int $xMin
     * @param int $xMax
     * @param int $yMin
     * @param int $yMax
     * @return Coordinates
     */
    public function generateCoordinates(int $xMin, int $xMax, int $yMin, int $yMax)
    {
        $tempCoordinates = null;
        while (is_null($tempCoordinates)) {
            $x = mt_rand($xMin, $xMax);
            $y = mt_rand($yMin, $yMax);
            $tempCoordinates = new Coordinates($x, $y);
            foreach ($this->getOccupiedCoordinates() as $coordinates) {
                if (($coordinates->getX() == $tempCoordinates->getX()) && $coordinates->getY() == $tempCoordinates->getY()) {
                    $tempCoordinates = null;
                }
            }
        }
        $this->setOccupiedCoordinates($tempCoordinates);
        return $tempCoordinates;
    }

    /**
     * @param Coordinates $occupiedCoordinates
     */
    public function setOccupiedCoordinates(Coordinates $occupiedCoordinates): void
    {
        array_push($this->occupiedCoordinates, $occupiedCoordinates);
    }
}