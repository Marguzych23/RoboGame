<?php


namespace App\Game\Model\InteractionObject\Trap;


class Breakdown extends Trap
{
    const TIME_OF_ACTION = 1;
    const NAME = 'Поломка';

    public function __construct()
    {
        $this->actionTime = self::TIME_OF_ACTION;
        $this->name = self::NAME;
    }

}