<?php


namespace App\Game\Model\Location;


use App\Game\Model\Coordinates;

class RainJungle extends Location
{
    const NAME = 'Дождевые джунгли';

    /**
     * RainJungle constructor.
     * @param Coordinates $startCoordinates
     */
    public function __construct(Coordinates $startCoordinates)
    {
        parent::__construct($startCoordinates, self::NAME);
    }

}