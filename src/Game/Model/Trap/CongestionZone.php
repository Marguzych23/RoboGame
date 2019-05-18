<?php


namespace App\Game\Model\Trap;


use App\Game\Model\Coordinates;

class CongestionZone extends Trap
{
    const TIME_OF_ACTION = 2;
    const NAME = 'Зона перегруженности';

    /**
     * CongestionZone constructor.
     * @param Coordinates $coordinates
     * @param int $timeOfAction
     */
    public function __construct(Coordinates $coordinates, $timeOfAction = self::TIME_OF_ACTION)
    {
        parent::__construct($coordinates, self::NAME, $timeOfAction);
    }

}