<?php


namespace App\Game\Model\Location;


class DesertArea extends Location
{
    const NAME = 'Пустынная область';

    /**
     * DesertArea constructor.
     * @param array $startCoordinates
     */
    public function __construct(array $startCoordinates)
    {
        parent::__construct($startCoordinates, self::NAME);
    }
}