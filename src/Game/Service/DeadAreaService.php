<?php


namespace App\Game\Service;


use App\Game\Model\Coordinates;
use App\Game\Model\DeadArea;
use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\Location\Location;
use App\Game\Model\Robot;
use App\Game\Model\Trap\Trap;

class DeadAreaService
{
    /** @var LocationService $locationService */
    protected $locationService;
    /** @var CoordinatesService $coordinatesService */
    protected $coordinatesService;
    /** @var RobotService $robotService */
    protected $robotService;

    /**
     * DeadAreaService constructor.
     * @param LocationService $locationService
     * @param RobotService $robotService
     * @param CoordinatesService $coordinatesService
     */
    public function __construct(LocationService $locationService, RobotService $robotService, CoordinatesService $coordinatesService)
    {
        $this->locationService = $locationService;
        $this->coordinatesService = $coordinatesService;
        $this->robotService = $robotService;
    }

    /**
     * @return Trap[]
     */
    public function generateTraps()
    {
        return array();
    }

    /**
     * @return Coordinates
     */
    public function generateLocationForRobot()
    {
        return $this->robotService->generateCoordinatesForRobot();
    }

    /**
     * @return Location[]
     */
    public function generateLocationsForArea()
    {
        return $this->locationService->generateLocationsForArea();
    }

    /**
     * @param Location[] $locations
     * @return InteractionObject[]|array
     */
    public function generateInteractionObjects(array $locations)
    {
        return $this->locationService->generateInteractionObjects($locations);
    }

    /**
     * @param Location[] $locations
     * @param Robot[] $robots
     * @param InteractionObject[] $interactionObjects
     * @param Trap[] $traps
     * @return DeadArea
     */
    public function generateDeadArea(array $locations, array $robots, array $interactionObjects, array $traps)
    {
        return new DeadArea($locations, $robots, $interactionObjects, $traps);
    }

}