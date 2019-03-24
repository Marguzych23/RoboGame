<?php


namespace App\Game\Model;


class Location
{
    const SIZE = 40;

    /** @var array $startCoordinates */
    protected $startCoordinates;
    /** @var array $interactionObjectsCoordinates */
    protected $interactionObjectsCoordinates;

    /**
     * Location constructor.
     * @param array $startCoordinates
     * @param array $interactionObjectsCoordinates
     */
    public function __construct(array $startCoordinates, array $interactionObjectsCoordinates)
    {
        if (empty($startCoordinates)) {
            $startCoordinates = array(0, 0);
        }
        $this->startCoordinates = $startCoordinates;
        $this->interactionObjectsCoordinates = $interactionObjectsCoordinates;
    }

    /**
     * @return array
     */
    public function getInteractionObjectsCoordinates(): array
    {
        return $this->interactionObjectsCoordinates;
    }

    /**
     * @param array $interactionObjectsCoordinates
     */
    public function setInteractionObjectsCoordinates(array $interactionObjectsCoordinates): void
    {
        $this->interactionObjectsCoordinates = $interactionObjectsCoordinates;
    }

    /**
     * @return array
     */
    public function getStartCoordinates(): array
    {
        return $this->startCoordinates;
    }

    /**
     * @param array $startCoordinates
     */
    public function setStartCoordinates(array $startCoordinates): void
    {
        $this->startCoordinates = $startCoordinates;
    }
}