<?php


namespace App\Game\Service;


use App\Game\Model\DeadArea;

class DeadAreaService
{

    /**
     * @param array $locations
     * @param array $robots
     * @param array $interactionObjects
     * @return DeadArea
     */
    public function generateDeadArea(array $locations, array $robots, array $interactionObjects)
    {
        return new DeadArea($locations, $robots, $interactionObjects);
    }

}