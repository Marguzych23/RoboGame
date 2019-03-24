<?php


namespace App\Game\Model\InteractionObject\Trap;


class SystemFailure extends Trap
{
    const TIME_OF_ACTION = 2;
    const NAME = 'Сбой в системе';

    public function __construct()
    {
        $this->actionTime = self::TIME_OF_ACTION;
        $this->name = self::NAME;
    }

}