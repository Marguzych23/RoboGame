<?php


namespace App\Game\Model\Location;


class RainJungle extends Location
{
    const NAME = 'Дождевые джунгли';

    /**
     * RainJungle constructor.
     * @param array $startCoordinates
     */
    public function __construct(array $startCoordinates)
    {
        parent::__construct($startCoordinates, self::NAME);
    }

}