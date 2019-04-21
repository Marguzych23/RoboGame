<?php


namespace App\Game\Service;


use App\Game\DTO\RobotViewedDeadAreaDTO;
use App\Game\Model\Step;

class ScriptService
{
    /**
     * @param RobotViewedDeadAreaDTO $robotViewedDeadAreaDTO
     * @return Step
     */
    public function getNextRobotStep(RobotViewedDeadAreaDTO $robotViewedDeadAreaDTO)
    {
//        TODO
        return new Step(null);
    }

    /**
     * @param string $script
     * @return bool
     */public function robotScriptCodeIsCorrect(string $script)
    {
//        TODO
        return true;
    }
}