<?php


namespace App\Game\Service;


use App\Game\Model\Robot;
use App\Game\Model\Step;

class ScriptService
{
    /**
     * @param Robot $robot
     * @param array $opponentsCoordinates
     * @return Step
     */
    public function getNextRobotStep(Robot $robot, array $opponentsCoordinates = array())
    {
//        TODO
        return new Step(null);
    }

    /**
     * @param string $script
     * @return bool
     */
    public function robotScriptCodeIsCorrect(string $script)
    {
//        TODO
        return true;
    }
}