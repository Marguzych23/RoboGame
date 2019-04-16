<?php


namespace App\Game\Model\InteractionObject\Trap;


use App\Game\Model\Coordinates;

class Breakdown extends Trap
{
    const TIME_OF_ACTION = 1;
    const NAME = 'Поломка';

    /**
     * Breakdown constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates, self::NAME);
        $this->actionTime = self::TIME_OF_ACTION;
        $this->name = self::NAME;
    }

}