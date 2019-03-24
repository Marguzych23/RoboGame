<?php


namespace App\Game\Model\Location;


use App\Game\Model\Coordinates;

class ElectricEarth extends Location
{
    const NAME = 'Электроземля';

    /**
     * ElectricEarth constructor.
     * @param Coordinates $startCoordinates
     */
    public function __construct(Coordinates $startCoordinates)
    {
        parent::__construct($startCoordinates, self::NAME);
    }

}