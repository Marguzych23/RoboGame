<?php


namespace App\Game\Model;


class Game
{
    /** @var DeadArea $deadArea */
    protected $deadArea;
    /** @var int $gameStepNumber */
    protected $gameStepNumber;

    /**
     * Game constructor.
     * @param DeadArea $deadArea
     */
    public function __construct(DeadArea $deadArea)
    {
        $this->deadArea = $deadArea;
        $this->gameStepNumber = 0;
    }

}