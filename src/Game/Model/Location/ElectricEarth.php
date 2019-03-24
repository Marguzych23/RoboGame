<?php


namespace App\Game\Model\Location;


class ElectricEarth extends Location
{
    const NAME = 'Электроземля';

    /**
     * ElectricEarth constructor.
     * @param array $startCoordinates
     */
    public function __construct(array $startCoordinates)
    {
        parent::__construct($startCoordinates, self::NAME);
    }

}