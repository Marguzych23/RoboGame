<?php


namespace App\Game\Model;


class DeadArea
{
    const START_SIZE = 100;

    /** @var int $currentStepSize */
    protected $currentStepSize;

    /** @var array $locationsCoordinates */
    protected $locationsCoordinates;

    /** @var array $robotsCoordinates */
    protected $robotsCoordinates;

    /** @var array $interactionObject */
    protected $interactionObject;

    /**
     * DeadArea constructor.
     * @param array $locationsCoordinates
     * @param array $robotsCoordinates
     * @param array $interactionObject
     * @param int $currentStepSize
     */
    public function __construct(array $locationsCoordinates, array $robotsCoordinates, array $interactionObject, int $currentStepSize = 0)
    {
        if ($currentStepSize < 1) {
            $currentStepSize = self::START_SIZE;
        }
        $this->currentStepSize = $currentStepSize;
        $this->locationsCoordinates = $locationsCoordinates;
        $this->robotsCoordinates = $robotsCoordinates;
        $this->interactionObject = $interactionObject;
    }

    /**
     * @return int
     */
    public function getCurrentStepSize(): int
    {
        return $this->currentStepSize;
    }

    /**
     * @param int $currentStepSize
     */
    public function setCurrentStepSize(int $currentStepSize): void
    {
        $this->currentStepSize = $currentStepSize;
    }

    /**
     * @return array
     */
    public function getLocationsCoordinates(): array
    {
        return $this->locationsCoordinates;
    }

    /**
     * @param array $locationsCoordinates
     */
    public function setLocationsCoordinates(array $locationsCoordinates): void
    {
        $this->locationsCoordinates = $locationsCoordinates;
    }

    /**
     * @return array
     */
    public function getRobotsCoordinates(): array
    {
        return $this->robotsCoordinates;
    }

    /**
     * @param array $robotsCoordinates
     */
    public function setRobotsCoordinates(array $robotsCoordinates): void
    {
        $this->robotsCoordinates = $robotsCoordinates;
    }

    /**
     * @return array
     */
    public function getInteractionObject(): array
    {
        return $this->interactionObject;
    }

    /**
     * @param array $interactionObject
     */
    public function setInteractionObject(array $interactionObject): void
    {
        $this->interactionObject = $interactionObject;
    }
}