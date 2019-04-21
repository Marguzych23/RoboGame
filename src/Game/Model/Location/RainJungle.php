<?php


namespace App\Game\Model\Location;


use App\Game\Model\Coordinates;

class RainJungle extends Location
{
    const NAME = 'Дождевые джунгли';

    /**
     * RainJungle constructor.
     * @param Coordinates $startCoordinates
     * @param int $size
     */
    public function __construct(Coordinates $startCoordinates, int $size = self::SIZE)
    {
        parent::__construct($startCoordinates, self::NAME);
    }

}