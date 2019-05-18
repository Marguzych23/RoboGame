<?php


namespace App\Game\DTO;


class DeadAreaDTO implements \JsonSerializable
{
    /** @var InteractionObjectDTO[] $interactionObjects */
    public $interactionObjects;
    /** @var RobotDTO[] $robots */
    public $robots;
    /** @var LocationDTO[] $locations */
    public $locations;

    /**
     * DeadAreaDTO constructor.
     * @param InteractionObjectDTO[] $interactionObjects
     * @param RobotDTO[] $robots
     * @param LocationDTO[] $locations
     */
    public function __construct(array $interactionObjects, array $robots, array $locations)
    {
        $this->interactionObjects = $interactionObjects;
        $this->robots = $robots;
        $this->locations = $locations;
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
        return $this->robots;
    }

    /**
     * @param RobotDTO[] $robots
     */
    public function setRobots(array $robots): void
    {
        $this->robots = $robots;
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
            'robots' => $this->robots,
            'locations' => $this->locations,
            'interactionObjects' => $this->interactionObjects,
        );
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_UNESCAPED_UNICODE);
    }
}