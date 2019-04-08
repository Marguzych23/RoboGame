<?php


namespace App\Game\Model;


use App\Game\Model\InteractionObject\InteractionObject;
use App\Game\Model\Location\Location;

class DeadArea implements \JsonSerializable
{
    const START_SIZE = 100;

    /** @var int $currentStepAreaSize */
    protected $currentStepAreaSize;

    /** @var Location[] $locations */
    protected $locations;

    /** @var Robot[] $robots */
    protected $robots;

    /** @var InteractionObject[] $interactionObjects */
    protected $interactionObjects;

    /**
     * DeadArea constructor.
     * @param array $locations
     * @param array $robots
     * @param array $interactionObjects
     * @param int $currentStepAreaSize
     */
    public function __construct(array $locations, array $robots, array $interactionObjects, int $currentStepAreaSize = self::START_SIZE)
    {
        if ($currentStepAreaSize < 1) {
            $currentStepAreaSize = self::START_SIZE;
        }
        $this->currentStepAreaSize = $currentStepAreaSize;
        $this->locations = $locations;
        $this->robots = $robots;
        $this->interactionObjects = $interactionObjects;
    }

    /**
     * @param Robot $robot
     * @return int
     */
    public function setRobot(Robot $robot)
    {
        return array_push($this->robots, $robot);
    }

    /**
     * @return int
     */
    public function getCurrentStepAreaSize(): int
    {
        return $this->currentStepAreaSize;
    }

    /**
     * @param int $currentStepAreaSize
     */
    public function setCurrentStepAreaSize(int $currentStepAreaSize): void
    {
        $this->currentStepAreaSize = $currentStepAreaSize;
    }

    /**
     * @return array
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    /**
     * @param array $locations
     */
    public function setLocations(array $locations): void
    {
        $this->locations = $locations;
    }

    /**
     * @return array
     */
    public function getRobots(): array
    {
        return $this->robots;
    }

    /**
     * @param array $robots
     */
    public function setRobots(array $robots): void
    {
        $this->robots = $robots;
    }

    /**
     * @return InteractionObject[]
     */
    public function getInteractionObjects(): array
    {
        return $this->interactionObjects;
    }

    /**
     * @param array $interactionObjects
     */
    public function setInteractionObjects(array $interactionObjects): void
    {
        $this->interactionObjects = $interactionObjects;
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
            'currentStepAreaSize' => $this->currentStepAreaSize,
            'locations' => $this->locations,
            'interactionObjects' => $this->interactionObjects,
        );
    }
}