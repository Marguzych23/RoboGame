<?php


namespace App\Game\Service;


use App\Game\Model\Robot;

class ScriptService
{
    /**
     * @param Robot $robot
     * @param array $opponentsCoordinates
     * @return array
     */
    public function getNextRobotStep(Robot $robot, array $opponentsCoordinates = array())
    {
        return array(0, 0);
    }
}