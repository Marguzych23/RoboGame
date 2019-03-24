<?php


namespace App\Game\Model\InteractionObject\Trap;


use App\Game\Model\Coordinates;

class CongestionZone extends Trap
{
    const TIME_OF_ACTION = 2;
    const NAME = 'Зона перегруженности';

    /**
     * CongestionZone constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates);
        $this->actionTime = self::TIME_OF_ACTION;
        $this->name = self::NAME;
    }

}