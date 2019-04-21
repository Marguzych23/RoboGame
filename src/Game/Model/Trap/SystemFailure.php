<?php


namespace App\Game\Model\Trap;


use App\Game\Model\Coordinates;

class SystemFailure extends Trap
{
    const TIME_OF_ACTION = 2;
    const NAME = 'Сбой в системе';

    /**
     * SystemFailure constructor.
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        parent::__construct($coordinates, self::NAME, self::TIME_OF_ACTION);
    }

}