<?php


namespace App\Game\Model\Location;


use App\Game\Model\Coordinates;

class DesertArea extends Location
{
    const NAME = 'Пустынная область';

    /**
     * DesertArea constructor.
     * @param Coordinates $startCoordinates
     */
    public function __construct(Coordinates $startCoordinates)
    {
        parent::__construct($startCoordinates, self::NAME);
    }
}