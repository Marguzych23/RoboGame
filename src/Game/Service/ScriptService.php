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
        return new Step();
    }

    /**
     * @param string $code
     * @return bool
     */
    public function robotCodeIsCorrect(string $code)
    {
//        TODO
        return true;
    }
}