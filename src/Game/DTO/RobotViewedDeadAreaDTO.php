<?php


namespace App\Game\DTO;


class RobotViewedDeadAreaDTO implements \JsonSerializable
{

    const SYSTEM_FAILURE_AREA_SIZE = 3;
    const START_AREA_SIZE = 5;

    /** @var CoordinatesDTO $viewed_area_start_coordinates */
    public $viewedAreaStartCoordinates;
    /** @var int $areaSize */
    public $areaSize;
    /** @var InteractionObjectDTO[] $interactionObjects */
    public $interactionObjects;
    /** @var RobotDTO[] $opponentsRobot */
    public $opponentsRobot;
    /** @var LocationDTO[] $locations */
    public $locations;

    /**
     * RobotViewedDeadAreaDTO constructor.
     * @param CoordinatesDTO $viewedAreaStartCoordinates
     * @param RobotDTO $robotDTO
     * @param int $areaSize
     * @param InteractionObjectDTO[] $interactionObjects
     * @param RobotDTO[] $opponentsRobot
     * @param LocationDTO[] $locations
     */
    public function __construct(CoordinatesDTO $viewedAreaStartCoordinates, RobotDTO $robotDTO, int $areaSize = self::START_AREA_SIZE, array $interactionObjects = array(), array $opponentsRobot = array(), array $locations = array())
    {
        $this->viewedAreaStartCoordinates = $viewedAreaStartCoordinates;
        $this->interactionObjects = $interactionObjects;
        $this->opponentsRobot = $opponentsRobot;
        $this->locations = $locations;
        $this->areaSize = $areaSize;
    }

    /**
     * @return InteractionObjectDTO[]
     */
    public function getInteractionObjects(): array
    {
        return $this->interactionObjects;
    }

    /**
     * @param InteractionObjectDTO[] $interactionObjects
     */
    public function setInteractionObjects(array $interactionObjects): void
    {
        $this->interactionObjects = $interactionObjects;
    }

    /**
     * @return RobotDTO[]
     */
    public function getRobots(): array
    {
        return $this->opponentsRobot;
    }

    /**
     * @param RobotDTO[] $opponentsRobot
     */
    public function setRobots(array $opponentsRobot): void
    {
        $this->opponentsRobot = $opponentsRobot;
    }

    /**
     * @return LocationDTO[]
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    /**
     * @param LocationDTO[] $locations
     */
    public function setLocations(array $locations): void
    {
        $this->locations = $locations;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'opponentsRobot' => $this->opponentsRobot,
            'locations' => $this->locations,
            'interactionObjects' => $this->interactionObjects,
        );
    }
}