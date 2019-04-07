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

    /**
     * @param Robot $robot
     * @return int
     */
    public function setRobot(Robot $robot) {
        return $this->getDeadArea()->setRobot($robot);
    }

    /**
     * @return array
     */
    public function getRobots() {
        return $this->getDeadArea()->getRobots();
    }

    /**
     * @return DeadArea
     */
    public function getDeadArea(): DeadArea
    {
        return $this->deadArea;
    }

    /**
     * @param DeadArea $deadArea
     */
    public function setDeadArea(DeadArea $deadArea): void
    {
        $this->deadArea = $deadArea;
    }

    /**
     * @return int
     */
    public function getGameStepNumber(): int
    {
        return $this->gameStepNumber;
    }

    /**
     * @param int $gameStepNumber
     */
    public function setGameStepNumber(int $gameStepNumber): void
    {
        $this->gameStepNumber = $gameStepNumber;
    }
}