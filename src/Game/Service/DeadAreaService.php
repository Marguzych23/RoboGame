<?php


namespace App\Game\Service;


use App\Game\Model\DeadArea;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\Location\Location;
use App\Game\Model\Robot;

class DeadAreaService
{

    /**
     * @param Location[] $locations
     * @param Robot[] $robots
     * @param InteractionObject[] $interactionObjects
     * @return DeadArea
     */
    public function generateDeadArea(array $locations, array $robots, array $interactionObjects)
    {
        return new DeadArea($locations, $robots, $interactionObjects);
    }

}